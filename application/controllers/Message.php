<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

	public function index(){
	
		$data['message'] = $this->db->select('*')->from('message')->order_by('id','desc')->get();
		$this->load->view('message',$data);
	
	}

	public function detail(){

		$detail = $this->db->select('*')->from('message')->where('id',$this->input->post('id'))->get()->row();

		if($detail){

			$this->db->where('id',$this->input->post('id'))->update('message',array('read_status'=>1));

			$arr['name'] = $detail->name;
			$arr['email'] = $detail->email;
			$arr['subject'] = $detail->subject;
			$arr['message'] = $detail->message;
			$arr['created_at'] = $detail->created_at;
			$arr['update_count_message'] = $this->db->where('read_status',0)->count_all_results('message');
			$arr['success'] = true;

		} else {

			$arr['success'] = false;
		}

		
		
		echo json_encode($arr);

	}

}