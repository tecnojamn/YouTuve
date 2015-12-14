<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminVideos extends MY_Controller {

    protected $data = array();
    protected $authorizedActions = array();

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $action = $this->router->fetch_method();

        if ($this->isAdminSignedIn()) {
            $this->data["adminname"] = $this->session->userdata['username'];
        }

        if (!$this->isAdminSignedIn() && !in_array($action, $this->authorizedActions)) {
            redirect('admin/adminSession/signin', 'refresh');
        }
    }

    public function viewsChart($idVideo) {
        $this->load->model("video_model");
        $views_data = $this->video_model->getViewsPerMonthById($idVideo, 6);
        //prepare data
        $raw_data = array();
        $month = (int) date("m");
        for ($i = 0; $i < 6; $i++) {
            $raw_data[$i]["month"] = $month;
            $raw_data[$i]["month_string"] = ucfirst($this->monthToSpanishString($month));
            $raw_data[$i]["views"] = 0;
            for ($j = 0; $j < count($views_data); $j++) {
                if ($views_data[$j]["month"] === $raw_data[$i]["month"]) {
                    $raw_data[$i]["views"] = (int) $views_data[$j]["views"];
                }
            }
            if ($month == 1)
                $month = 13; //fix
            $month--;
        }
        $raw_data = array_reverse($raw_data);
        $this->data["chart"] = json_encode($this->prepareViewsChartData($raw_data));
        $this->load->view('admin/chart_video_views_layout', $this->data);
        //var_dump($this->data["chart"]);
    }

    private function prepareViewsChartData($chart_raw_data) {
        $chart_data = new stdClass();
        $labels = array();
        $views_data = array();
        for ($i = 0; $i < count($chart_raw_data); $i++) {
            $views_data[] = $chart_raw_data[$i]["views"];
            $labels[] = $chart_raw_data[$i]["month_string"];
        }
        $chart_data->labels = $labels;
        $chart_data->datasets[] = array('label' => "Vistas en los ultimos 6 meses",
            'data' => $views_data, "fillColor" => "rgba(220,220,220,0.5)",
            "strokeColor" => "rgba(220,220,220,0.8)",
            "highlightStroke" => "rgba(220,220,220,1)",
            "highlightFill" => "rgba(220,220,220,0.5)");
        return $chart_data;

        /* var data = {
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [
          {
          label: "My First dataset",
          fillColor: "rgba(220,220,220,0.5)",
          strokeColor: "rgba(220,220,220,0.8)",
          highlightFill: "rgba(220,220,220,0.75)",
          highlightStroke: "rgba(220,220,220,1)",
          data: [65, 59, 80, 81, 56, 55, 40]
          }]}; */
    }

    //util function
    private function monthToString($int_month) {
        $dateObj = DateTime::createFromFormat('!m', $int_month);
        /* @var $monthName String */
        return $monthName = $dateObj->format('F'); // March
    }

    private function monthToSpanishString($int_month) {
        $spanish_months = array(
            'January' => 'enero',
            'February' => 'febrero',
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre'
        );
        return $spanish_months[$this->monthToString($int_month)];
    }

    //the table view here
    public function index() {
        //esta es la pagina se entra si se pone www.mipagina.com/Video 
        /* $data["log"] = 0;
          if ($this->isAuthorized()) {
          $data["log"] = 1;
          } */
        $this->load->library('pagination');
        $this->load->model("admin_model");
        $this->load->model("video_model");
        $configPager['base_url'] = base_url() . 'admin/adminvideos/index';
        $configPager['total_rows'] = $this->video_model->getVideosQuantity();
        $configPager["uri_segment"] = 4;
        $configPager['per_page'] = 10;
        $this->pagination->initialize($configPager);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['links'] = $this->pagination->create_links();
        $videos = $this->video_model->getVideosForAdmin($page, $configPager['per_page']);
        $this->data['videos'] = $videos;
        $this->load->view('admin/videos_dashboard_layout', $this->data);
        return;
    }

    //logical delete
    public function activate() {
        $this->load->library('session'); //no necesario debido a que esta en el constructor
        $this->load->model("video_model");
        $this->load->model("admin_model");
        $id = $this->uri->segment(4, 0);
        $this->video_model->activate($id);
        $this->session->set_flashdata('message', 'Video dado de alta.');
        $this->session->set_flashdata('error', 0);
        redirect('admin/adminVideos/index', 'refresh');
        return;
    }

    //logical undelete
    public function deactivate() {
        $this->load->library('session'); //no necesario debido a que esta en el constructor
        $this->load->model("video_model");
        $this->load->model("admin_model");
        $id = $this->uri->segment(4, 0);
        $this->video_model->deactivate($id);
        $this->session->set_flashdata('message', 'Video dado de baja.');
        $this->session->set_flashdata('error', 0);
        redirect('admin/adminVideos/index', 'refresh');
        return;
    }

    public function gotoVideo() {
        
    }

}
