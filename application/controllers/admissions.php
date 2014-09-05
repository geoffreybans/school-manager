<?php
/** 
 * This class has methods that will handle of queries within the admissions dashboard 
 * 
 * It containd the addnew method
 * It has the view method 
 * It has the update method 
 * It also has the delete method
 * It will help to generate clean URLs
 */
 class Admissions extends Admissions_Controller {
 
/**
 *This method, index, is the default and loads the login page into the admissions dashboard
 *After successful login, the user is redirected to the admissions dashboard
 */
	public function index() 
	{
		//$this->load->view('admissions/header');
		$this->load->view('admissions/header');
		$this->load->view('admissions/home');
		$this->load->view('admissions/footer');
	}
	

/**
 *This method, addnew, handles all addnew queries
 *
 *I have used loops a lot in this method to enable it handle all the queries
 *from the addnew control panel 
 *This loops uniquely identify steps in the registrstion process and call the appropriate loop 
 */ 
	
 
	public function addnew() 
	{
	
/**
 *This loops loads the step one registration, because at this point no form has been
 *submitted so there is no $_POST data
 *
 */
 
		if( ! $_POST)
		{
			$this->load->view('admissions/header');
			$this->load->view('admissions/addnew1');
			$this->load->view('admissions/footer');
			
		}
	
/**
 *The existence of $_POST data means a form has been submitted and so we go 
 *ahead to identify which form it is by checking the data submitted in the hidden field actionflag
 *
*/ 
		if($_POST)
		{
			if($this->input->post('actionflag') == 'step1') 
			{
			
				if($this->input->post('is_ajax'))
				{
					$input['adm'] = $this->input->post('adm');
					$input['actionf'] = 'step1';
					$input['f_name'] = strtoupper($this->input->post('f_name'));
					$input['m_name'] = strtoupper($this->input->post('m_name'));
					$input['l_name'] = strtoupper($this->input->post('l_name'));
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res->num_rows() > 0 ) 
					{
						$data['error'] = "Error. This Admission Number is already in use. Please assign another.";
						
						$this->load->view('admissions/addnew1', $data);
					}
					else 
					{
						$input['actionf'] = 'basic_details';
						$this->load->model('admissions/admission');
						$res2 = $this->admission->insert($input);
					
					
						if($res2) 
						{
							$sess['adm'] = $input['adm'];
							$this->session->set_userdata('sess', $sess);
							
							$input['action'] = 'get';
							$input['actionf'] = 'get_classes';
							
							$this->load->model('admissions/admission');
							$classes = $this->admission->insert($input);
							
								$class = $classes->row();
								$input['class'] = $class->CLASS;
								$input['action'] = 'get';
								$input['actionf'] = 'get_streams';
								
								$this->load->model('admissions/admission');
								$streams = $this->admission->insert($input);
							
							$data['success'] = "Success. You entered the basic details successfully.";							
							$data['classes'] = $classes;
							$data['streams'] = $streams;
							
							$this->load->view('admissions/addnew2', $data);
						
						}
						
					}
					
				}
				
				else
				{
					
					$input['adm'] = $this->input->post('adm');
					$input['actionf'] = 'step1';
					$input['f_name'] = strtoupper($this->input->post('f_name'));
					$input['m_name'] = strtoupper($this->input->post('m_name'));
					$input['l_name'] = strtoupper($this->input->post('l_name'));
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
				
					if($res->num_rows() > 0 ) 
					{
						$data['error'] = "Error. This Admission Number is already in use. Please assign another.";

						
						$this->load->view('admissions/header');
						$this->load->view('admissions/addnew1',$data);
						$this->load->view('admissions/footer');
					}
					else 
					{
						$input['actionf'] = 'basic_details';
						$this->load->model('admissions/admission');
						$res2 = $this->admission->insert($input);
					
					
						if($res2) 
						{
							$sess['adm'] = $input['adm'];
							$this->session->set_userdata('sess', $sess);
							
							$input['action'] = 'get';
							$input['actionf'] = 'get_classes';
							
							$this->load->model('admissions/admission');
							$classes = $this->admission->insert($input);
							
								$class = $classes->row();
								$input['class'] = $class->CLASS;
								$input['action'] = 'get';
								$input['actionf'] = 'get_streams';
								
								$this->load->model('admissions/admission');
								$streams = $this->admission->insert($input);
							
							$data['success'] = "Success. You entered the basic details successfully.";							
							$data['classes'] = $classes;
							$data['streams'] = $streams;
							
							$this->load->view('admissions/header');
							$this->load->view('admissions/addnew2', $data);
							$this->load->view('admissions/footer');
						
						}
						
					}
					
				}
				
			}
		
		
			if($this->input->post('actionflag') == 'step2')
			{	
				if($this->input->post('actionf') == 'get_streams')
				{
					
					$input['class'] = $this->input->post('class1');
					$input['action'] = 'get';
					$input['actionf'] = 'get_streams';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res)
					{
						
						if($res->num_rows() > 0)
						{
							
							$html = "<p>Streams: <select name=\"stream\" id=\"stream\">";
							
							foreach($res->result() as $row)
							{
								$html .= "<option value=\"{$row->STREAMS}\">{$row->STREAMS}</option>";
							
							}
							
							$html .= "</select></p>";
							
							echo $html;
							exit;
						
						}
						else
						{
							echo "<p style=\" color: #ff6666; \">This class has no registered streams</p>";
							exit;
						
						}
						
					}
					else if(!$res)
					{
						echo "<p style=\" color: #ff6666; \">This class has no registered streams</p>";
						exit;
					
					}
				
				}
				
				if($this->input->post('is_ajax'))
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['dob'] = $this->input->post('dob');
					$input['pob'] = $this->input->post('pob');
					$input['doa'] = $this->input->post('doa');
					$input['caa'] = $this->input->post('caa');
					$input['county'] = $this->input->post('county');
					$input['gender'] = $this->input->post('gender');
					$input['nationality'] = $this->input->post('nationality');
					$input['actionf'] = 'pdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the personal details successfully.";
						$this->load->view('admissions/addnew3', $data);
					}
				
				}
				else
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['dob'] = $this->input->post('dob');
					$input['pob'] = $this->input->post('pob');
					$input['doa'] = $this->input->post('doa');
					$input['caa'] = $this->input->post('caa');
					$input['county'] = $this->input->post('county');
					$input['gender'] = $this->input->post('gender');
					$input['nationality'] = $this->input->post('nationality');
					$input['actionf'] = 'pdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the personal details successfully.";
						
						$this->load->view('admissions/header');
						$this->load->view('admissions/addnew3', $data);
						$this->load->view('admissions/footer');
					}
					
				}
			
			}
			
			if($this->input->post('actionflag') == 'step3')
			{	
				if($this->input->post('is_ajax'))
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['pa'] = $this->input->post('pa');
					$input['pc'] = $this->input->post('pc');
					$input['town'] = $this->input->post('town');
					$input['actionf'] = 'cdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the contact details successfully.";
						$this->load->view('admissions/addnew4', $data);
					
					}

				
				}
				else
				{
				
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['pa'] = $this->input->post('pa');
					$input['pc'] = $this->input->post('pc');
					$input['town'] = $this->input->post('town');
					$input['actionf'] = 'cdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the contact details successfully.";
						$this->load->view('admissions/header');
						$this->load->view('admissions/addnew4', $data);
						$this->load->view('admissions/footer');
					
					}
					
				}

			}
			
			if($this->input->post('actionflag') == 'step4')
			{	
				if($this->input->post('is_ajax'))
				{
					$data['success'] = "Success. You uploaded the passport photo successfully.";
					$this->load->view('admissions/addnew5', $data);
				
				}
				else
				{
					$data['success'] = "Success. You uploaded the passport photo successfully.";
					
					$this->load->view('admissions/header');
					$this->load->view('admissions/addnew5', $data);
					$this->load->view('admissions/footer');
				
				}
				
			}
			
			if($this->input->post('actionflag') == 'step5')
			{
				if($this->input->post('is_ajax'))
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['f_name'] = $this->input->post('f_name');
					$input['l_name'] = $this->input->post('l_name');
					$input['paddress'] = $this->input->post('paddress');
					$input['pcode'] = $this->input->post('pcode');
					$input['phone'] = $this->input->post('pcode');
					$input['email'] = $this->input->post('email');
					$input['actionf'] = 'fdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the father's details successfully." ;
						$this->load->view('admissions/addnew6', $data);
						
					}
				
				}
				else
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['f_name'] = $this->input->post('f_name');
					$input['l_name'] = $this->input->post('l_name');
					$input['paddress'] = $this->input->post('paddress');
					$input['pcode'] = $this->input->post('pcode');
					$input['phone'] = $this->input->post('pcode');
					$input['email'] = $this->input->post('email');
					$input['actionf'] = 'fdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the father's details successfully." ;
						$this->load->view('admissions/header');
						$this->load->view('admissions/addnew6', $data);
						$this->load->view('admissions/footer');
						
					}
				
				}
				
			}
			
			if($this->input->post('actionflag') == 'step6')
			{	
				if($this->input->post('is_ajax'))
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['f_name'] = $this->input->post('f_name');
					$input['l_name'] = $this->input->post('l_name');
					$input['paddress'] = $this->input->post('paddress');
					$input['pcode'] = $this->input->post('pcode');
					$input['phone'] = $this->input->post('pcode');
					$input['email'] = $this->input->post('email');
					$input['actionf'] = 'mdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the mother's details successfully." ;
						$this->load->view('admissions/addnew7', $data);
						
					}
				
				}
				else
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['f_name'] = $this->input->post('f_name');
					$input['l_name'] = $this->input->post('l_name');
					$input['paddress'] = $this->input->post('paddress');
					$input['pcode'] = $this->input->post('pcode');
					$input['phone'] = $this->input->post('pcode');
					$input['email'] = $this->input->post('email');
					$input['actionf'] = 'mdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You entered the mother's details successfully." ;
						$this->load->view('admissions/header');
						$this->load->view('admissions/addnew7', $data);
						$this->load->view('admissions/footer');
						
					}
					
				}
				
			}
			
			if($this->input->post('actionflag') == 'step7')
			{	
				if($this->input->post('is_ajax'))
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['f_name'] = $this->input->post('f_name');
					$input['l_name'] = $this->input->post('l_name');
					$input['paddress'] = $this->input->post('paddress');
					$input['pcode'] = $this->input->post('pcode');
					$input['phone'] = $this->input->post('pcode');
					$input['email'] = $this->input->post('email');
					$input['actionf'] = 'gdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You registered the student successfully. To view the details, use the view link above." ;
						$this->load->view('admissions/addnew1', $data);
						
					}
				
				}
				else
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['f_name'] = $this->input->post('f_name');
					$input['l_name'] = $this->input->post('l_name');
					$input['paddress'] = $this->input->post('paddress');
					$input['pcode'] = $this->input->post('pcode');
					$input['phone'] = $this->input->post('pcode');
					$input['email'] = $this->input->post('email');
					$input['actionf'] = 'gdetails';
					
					$this->load->model('admissions/admission');
					$res = $this->admission->insert($input);
					
					if($res) 
					{
						$data['success'] = "Success. You registered the student successfully. To view the details, use the view link above." ;
						$this->load->view('admissions/header');
						$this->load->view('admissions/addnew1', $data);
						$this->load->view('admissions/footer');
						
					}
					
				}
			
			}
			
		}
		
		if($_FILES)
		{
			//when the user selects and file, uploads it and then submits it, the $_FILES variable will be available.
			//in the varibles below we set the upload folder path, the allowed file types, which we have set to .csv to avoid raw excel data 
			//being inserted because this will ruin the database.
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'png|jpg|jpeg|gif';
			$config['max_size'] = '10000';
		
			$this->load->library('upload', $config);
		
			if( ! $this->upload->do_upload())
			{
				//if the do_upload() function does not run successfully, it means theres is an error, therefore we redisplay the upload form with the appropriate error message.
				$data['error'] = $this->upload->display_errors();
				
				$this->load->view('academics/header');
				$this->load->view('academics/upload2', $data);
				$this->load->view('academics/footer');
		
			}
		
			else
			{
				//this means the upload was successful and so we ask the user ti cinfirm entering the data into the database before we actually insert into mysql.
				$data = array( 'upload_data' => $this->upload->data());
				$this->session->set_userdata('file_path', $data['upload_data']['full_path']);
				
				$this->load->view('academics/header');
				$this->load->view('academics/confirm');
				$this->load->view('academics/footer');
		
			}
		
		
		}
	
		
	}

	public function get()
	{
		if($this->input->post('actionf') == 'get_streams')
		{
			$info['class'] = $this->input->post('class');
			$info['actionf'] = $this->input->post('actionf');
			
			$this->load->model('admissions/admission');
			$data['streams'] = $this->admission->get($info);
			
			$this->load->view('admissions/json', $data);
		
		}
	
	}
	
/**
 *This method, view, handles all view operations from the view panel in the dashboard
 *
 *We will identify the various requests by a unique hidden field in every form submission
 *In this case this is an actionflag variable with a unique value assigned to it in a hidden field
 */
	
	public function view() 
	{
		if(!$_POST)
		{
			$this->load->view('admissions/header');
			$this->load->view('admissions/view1');
			$this->load->view('admissions/footer');
		
		}
		
		if($_POST)
		{
			if($this->input->post('actionflag') == 'step1')
			{
				if($this->input->post('is_ajax'))
				{
					$input['actionf'] = $this->input->post('actionflag');
					$input['adm'] = $this->input->post('adm');
					
					$this->load->model('admissions/admission');
					$res = $this->admission->view($input);
					
					if($res->num_rows() == 0)
					{
						$data['error'] = "Error. A student with this Admission Number does not exist.";
						$this->load->view('admissions/view1', $data);
					
					}
					
					else
					{
						$sess['adm'] = $input['adm'];
						foreach($res->result() as $row)
						{
							$sess['f_name'] = $row->f_name;
							$sess['m_name'] = $row->m_name;
							$sess['l_name'] = $row->l_name;
						}
						$this->session->set_userdata('sess', $sess);
						
						$data['success'] = "Success. Student found.";
						$this->load->view('admissions/view2', $data);

					}
				
				}
				else
				{
					$input['actionf'] = $this->input->post('actionflag');
					$input['adm'] = $this->input->post('adm');
					
					$this->load->model('admissions/admission');
					$res = $this->admission->view($input);
					
					if($res->num_rows() == 0)
					{
						$data['error'] = "Error. A student with this Admission Number does not exist.";
						$this->load->view('admissions/header');
						$this->load->view('admissions/view1', $data);
						$this->load->view('admissions/footer');
					
					}
					
					else
					{
						$sess['adm'] = $input['adm'];
						foreach($res->result() as $row)
						{
							$sess['f_name'] = $row->f_name;
							$sess['m_name'] = $row->m_name;
							$sess['l_name'] = $row->l_name;
						}
						$this->session->set_userdata('sess', $sess);
						
						$data['success'] = "Success. Student found.";
						
						$this->load->view('admissions/header');
						$this->load->view('admissions/view2', $data);
						$this->load->view('admissions/footer');

					}
					
				}
				
			}
			
			if($this->input->post('actionflag') == 'step2')
			{
				if($this->input->post('is_ajax'))
				{
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['actionf'] = $this->input->post('actionflag');

					if($this->input->post('pdetails'))
					{
						$input['tablename'] = 'personal';
						
						$this->load->model('admissions/admission');
						$data['personal'] = $this->admission->view($input);
						
						$input['tablename'] = 'contacts';
						
						$this->load->model('admissions/admission');
						$data['contacts'] = $this->admission->view($input);
						
					}
					
					if($this->input->post('pgdetails'))
					{
						$input['tablename'] = 'father_details';
						
						$this->load->model('admissions/admission');
						$data['father_details'] = $this->admission->view($input);
						
						$input['tablename'] = 'mother_details';
						
						$this->load->model('admissions/admission');
						$data['mother_details'] = $this->admission->view($input);
						
						$input['tablename'] = 'guardian_details';
						
						$this->load->model('admissions/admission');
						$data['guardian_details'] = $this->admission->view($input);
					
					}
					
					$data['success'] = "Success. Find the student info below.";
					$this->load->view('admissions/view3', $data);
				
				}
				else
				{
					
					$output = $this->session->userdata('sess');
					$input['adm'] = $output['adm'];
					$input['actionf'] = $this->input->post('actionflag');

					if($this->input->post('pdetails'))
					{
						$input['tablename'] = 'personal';
						
						$this->load->model('admissions/admission');
						$data['personal'] = $this->admission->view($input);
						
						$input['tablename'] = 'contacts';
						
						$this->load->model('admissions/admission');
						$data['contacts'] = $this->admission->view($input);
						
					}
					
					if($this->input->post('pgdetails'))
					{
						$input['tablename'] = 'father_details';
						
						$this->load->model('admissions/admission');
						$data['father_details'] = $this->admission->view($input);
						
						$input['tablename'] = 'mother_details';
						
						$this->load->model('admissions/admission');
						$data['mother_details'] = $this->admission->view($input);
						
						$input['tablename'] = 'guardian_details';
						
						$this->load->model('admissions/admission');
						$data['guardian_details'] = $this->admission->view($input);
					
					}
					
					$data['success'] = "Success. Find the student info below.";
					
					$this->load->view('admissions/header');
					$this->load->view('admissions/view3', $data);
					$this->load->view('admissions/footer');
				
				}
				
			}
			
		}
	
	}
	
//=============================================================================================//
	public function update() 
	{
		if(!$_POST && $this->uri->segment(3) === FALSE)
		{
			$this->load->view('admissions/header');
			$this->load->view('admissions/update/choose_adm');
			$this->load->view('admissions/footer');
		
		}
		
		if($_POST)
		{
			if($this->input->post('actionflag') == 'step1')
			{
				$input['actionf'] = $this->input->post('actionflag');
				$input['adm'] = $this->input->post('adm');
				
				$sess['adm'] = $input['adm'];
				$this->session->set_userdata('sess', $sess);
				
				$this->load->model('admissions/admission');
				$res = $this->admission->update($input);
				
				
				
				if($res->num_rows() > 0)
				{
					
					foreach($res->result() as $row)
					{
						$sess['f_name'] = $row->f_name;
						$sess['m_name'] = $row->m_name;
						$sess['l_name'] = $row->l_name;
						$this->session->set_userdata('sess', $sess);
					
					}
					
					$data['success'] = "Success. Student found.";

					if($this->input->post('is_ajax'))
					{
						$this->load->view('admissions/update/view2', $data);
					
					}
					
					else
					{
						$this->load->view('admissions/header');
						$this->load->view('admissions/update/view2', $data);
						$this->load->view('admissions/footer');
					
					}

				}
				
				else
				{
					$data['error'] = "A student with this Admission Number does not exist. Choose another.";
					
					if($this->input->post('is_ajax'))
					{
						$this->load->view('admissions/update/choose_adm', $data);
					
					}
					else
					{
						$this->load->view('admissions/header');
						$this->load->view('admissions/update/choose_adm', $data);
						$this->load->view('admissions/footer');
					
					}
					
				}
				
			}
			
			if($this->input->post('actionflag') == 'step2')
			{
				$output = $this->session->userdata('sess');
				$input['adm'] = $output['adm'];
				$input['actionf'] = $this->input->post('actionflag');

				if($this->input->post('pdetails'))
				{
					$input['actionf'] = 'get_bdetails';
					
					$this->load->model('admissions/admission');
					$data['basic'] = $this->admission->update($input);
					
					$input['actionf'] = 'get_pdetails';
					
					$this->load->model('admissions/admission');
					$data['personal'] = $this->admission->update($input);
					
					$input['actionf'] = 'get_contacts';
					
					$this->load->model('admissions/admission');
					$data['contacts'] = $this->admission->update($input);
					
				}
				
				if($this->input->post('pgdetails'))
				{
					$input['actionf'] = 'get_fdetails';
					
					$this->load->model('admissions/admission');
					$data['father_details'] = $this->admission->update($input);
					
					$input['actionf'] = 'get_mdetails';
					
					$this->load->model('admissions/admission');
					$data['mother_details'] = $this->admission->update($input);
					
					$input['actionf'] = 'get_gdetails';
					
					$this->load->model('admissions/admission');
					$data['guardian_details'] = $this->admission->update($input);
				
				}
				
				$data['success'] = "Success. View the records below.";
				
				if($this->input->post('is_ajax'))
				{
					$this->load->view('admissions/update/view3', $data);
				
				}
				
				else
				{
				
					$this->load->view('admissions/header');
					$this->load->view('admissions/update/view3', $data);
					$this->load->view('admissions/footer');
			
				}
				
			}
			
		}
		
		if($this->uri->segment(3) == 'personal')
		{
			$output = $this->session->userdata('sess');
			$input['actionf'] = 'get_pdetails';
			$input['adm'] = $output['adm'];
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$data['success'] = "Success";
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/pdetails', $data);
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/pdetails', $data);
				$this->load->view('admissions/footer');

			}
			
		}
		
		if($this->uri->segment(3) == 'personal_up')
		{	
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'personal';
			
			if($this->input->post('dob'))
			{
				$input['dob'] = $this->input->post('dob');
			
			}
			if($this->input->post('pob'))
			{	
				$input['pob'] = $this->input->post('pob');
			
			}
			if($this->input->post('doa'))
			{
				$input['doa'] = $this->input->post('doa');
			
			}
			if($this->input->post('coa'))
			{
				$input['coa'] = $this->input->post('coa');
			
			}
			if($this->input->post('county'))
			{
				$input['county'] = $this->input->post('county');
			
			}
			if($this->input->post('gender'))
			{
				$input['gender'] = $this->input->post('gender');
			
			}
			if($this->input->post('nationality'))
			{
				$input['nationality'] = $this->input->post('nationality');
			
			}
			
			$this->load->model('admissions/admission');
			$this->admission->update($input);
			
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_pdetails';
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
		
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['father_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mother_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['guardian_details'] = $this->admission->update($input);
			
			$data['success'] = "Success";
		
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/view3', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/view3', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'basic')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$data['success'] = 'Success';
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/basic', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/basic', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'basic_up')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'basic';
			
			if($this->input->post('f_name'))
			{
				$input['f_name'] = $this->input->post('f_name');
				
			}
			if($this->input->post('m_name'))
			{
				$input['m_name'] = $this->input->post('m_name');
			
			}
			if($this->input->post('l_name'))
			{
				$input['l_name'] = $this->input->post('l_name');
			
			}
			
			$this->load->model('admissions/admission');
			$this->admission->update($input);
			
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_pdetails';
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['father_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mother_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['guardian_details'] = $this->admission->update($input);
			
			$data['success'] = "Success";
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/view3', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/view3', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'contacts')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
			$data['success'] = 'Success';
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/contacts', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/contacts', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'contacts_up')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'contacts';
			
			if($this->input->post('paddress'))
			{
				$input['paddress'] = $this->input->post('paddress');
				
			}
			if($this->input->post('pcode'))
			{
				$input['pcode'] = $this->input->post('pcode');
			
			}
			if($this->input->post('town'))
			{
				$input['town'] = $this->input->post('town');
			
			}
			
			$this->load->model('admissions/admission');
			$this->admission->update($input);
			
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_pdetails';
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['father_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mother_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['guardian_details'] = $this->admission->update($input);
			
			$data['success'] = "Success";
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/view3', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/view3', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'fdetails')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['fdetails'] = $this->admission->update($input);
			
			$data['success'] = 'Success';
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/fdetails', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/fdetails', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'fdetails_up')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'fdetails';
			
			if($this->input->post('f_name'))
			{
				$input['f_name'] = $this->input->post('f_name');
				
			}
			if($this->input->post('l_name'))
			{
				$input['l_name'] = $this->input->post('l_name');
			
			}
			if($this->input->post('paddress'))
			{
				$input['paddress'] = $this->input->post('paddress');
			
			}
			
			if($this->input->post('pcode'))
			{
				$input['pcode'] = $this->input->post('pcode');
			
			}
			if($this->input->post('phone'))
			{
				$input['phone'] = $this->input->post('phone');
			
			}
			
			if($this->input->post('email'))
			{
				$input['email'] = $this->input->post('email');
			
			}
			
			$this->load->model('admissions/admission');
			$this->admission->update($input);
			
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_pdetails';
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['father_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mother_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['guardian_details'] = $this->admission->update($input);
			
			$data['success'] = "Success";
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/view3', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/view3', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'mdetails')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mdetails'] = $this->admission->update($input);
			
			$data['success'] = 'Success';
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/mdetails', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/mdetails', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'mdetails_up')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'mdetails';
			
			if($this->input->post('f_name'))
			{
				$input['f_name'] = $this->input->post('f_name');
				
			}
			if($this->input->post('l_name'))
			{
				$input['l_name'] = $this->input->post('l_name');
			
			}
			if($this->input->post('paddress'))
			{
				$input['paddress'] = $this->input->post('paddress');
			
			}
			
			if($this->input->post('pcode'))
			{
				$input['pcode'] = $this->input->post('pcode');
			
			}
			if($this->input->post('phone'))
			{
				$input['phone'] = $this->input->post('phone');
			
			}
			
			if($this->input->post('email'))
			{
				$input['email'] = $this->input->post('email');
			
			}
			
			$this->load->model('admissions/admission');
			$this->admission->update($input);
			
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_pdetails';
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['father_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mother_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['guardian_details'] = $this->admission->update($input);
			
			$data['success'] = "Success";
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/view3', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/view3', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'gdetails')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['gdetails'] = $this->admission->update($input);
			
			$data['success'] = 'Success';
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/gdetails', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/gdetails', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}
		
		if($this->uri->segment(3) == 'gdetails_up')
		{
			$output = $this->session->userdata('sess');
			$input['adm'] = $output['adm'];
			$input['actionf'] = 'gdetails';
			
			if($this->input->post('f_name'))
			{
				$input['f_name'] = $this->input->post('f_name');
				
			}
			if($this->input->post('l_name'))
			{
				$input['l_name'] = $this->input->post('l_name');
			
			}
			if($this->input->post('paddress'))
			{
				$input['paddress'] = $this->input->post('paddress');
			
			}
			
			if($this->input->post('pcode'))
			{
				$input['pcode'] = $this->input->post('pcode');
			
			}
			if($this->input->post('phone'))
			{
				$input['phone'] = $this->input->post('phone');
			
			}
			
			if($this->input->post('email'))
			{
				$input['email'] = $this->input->post('email');
			
			}
			
			$this->load->model('admissions/admission');
			$this->admission->update($input);
			
			$input['actionf'] = 'get_bdetails';
			
			$this->load->model('admissions/admission');
			$data['basic'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_pdetails';
			
			$this->load->model('admissions/admission');
			$data['personal'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_contacts';
			
			$this->load->model('admissions/admission');
			$data['contacts'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_fdetails';
			
			$this->load->model('admissions/admission');
			$data['father_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_mdetails';
			
			$this->load->model('admissions/admission');
			$data['mother_details'] = $this->admission->update($input);
			
			$input['actionf'] = 'get_gdetails';
			
			$this->load->model('admissions/admission');
			$data['guardian_details'] = $this->admission->update($input);
			
			$data['success'] = "Success";
			
			if($this->input->post('is_ajax'))
			{
				$this->load->view('admissions/update/view3', $data);
			
			}
			else
			{
				$this->load->view('admissions/header');
				$this->load->view('admissions/update/view3', $data);
				$this->load->view('admissions/footer');
			
			}
			
		}

	
	}
	
	
//=============================================================================================//
	public function delete() 
	{
	
	
	}
 
 }
 


