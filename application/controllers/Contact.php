<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/Contact
	 *	- or -
	 * 		http://example.com/index.php/Contact/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/projects/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */



    
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
        
        
	public function index()
	{
		$this->load->view('contact');
	}

	public function sendmeform()
	{
	    $name = $this->input->post('name');
	    $email = $this->input->post('email');
	    $message = $this->input->post('comments');

// Load PHPMailer library
                    $this->load->library('phpmailer_lib');
                    
                    // PHPMailer object
                    $mail = $this->phpmailer_lib->load();
                    
                    $mail->isSMTP(true);
            	    $mail->Port = 25; 
            	    $mail->Host = 'localhost';
            	    $mail->SMTPAuth = false;
            	    $mail->SMTPAutoTLS = false; 
                    $mail->SMTPSecure = "none";
                    $mail->Username = 'beetechnology9@gmail.com';
                    $mail->Password = 'Pp@ssadminbee';
                    // $mail->SMTPDebug = 2;
                    
                    
                    $mail->setFrom($email, $name);
                    // $mail->addReplyTo('info@example.com', 'CodexWorld');
                    
                    // Add a recipient
                    $mail->addAddress('info@beetechnology.in');
                    
                    // Add cc or bcc 
                    // $mail->addCC('robert.cloudy@outlook.com');
                    
                    // Email subject
              		$mail->Subject = "BEE TECH Contact Form";
                    
                    // Set email format to HTML
                    $mail->isHTML(true);
              		$data = 0;
              		$mail->Body = '
            		    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            		    	<html xmlns="http://www.w3.org/1999/xhtml">
            			    <head>
            			      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            			      <title>Contact Me Form</title>
            			    </head>
            	    
            			    <body style="margin:0; padding:0; font:13px Arial, tahoma, Verdana, Helvetica, sans-serif;">
            			      <div align="left" style="width:100%; margin:auto; background:#fff; color:#000;">
            			        <div align="left" style="padding:20px;">
            			                  <div align="left" style="background:#fff; margin-bottom:15px; font-size:18px; font-weight:bold; color:#000;">Contact Me Form</div>
            			                        <table width="100%" border="0" cellspacing="1" cellpadding="1" style="background:#ccc;">
            			                          <tr>
            			                            <td width="50%" align="left" valign="middle" style="background:#fff; padding:3px;">Name:</td>
            			                            <td width="50%" align="left" valign="middle" style="background:#fff; padding:3px;">'.$name.'</td>
            			                          </tr>
            			              <tr>
            			                            <td align="left" valign="middle" style="background:#fff; padding:3px;"><strong>Email:</strong></td>
            			                            <td align="left" valign="middle" style="background:#fff; padding:3px;">'.$email.'</td>
            			                          </tr>
            			              <tr>
            			                            <td align="left" valign="middle" style="background:#fff; padding:3px;"><strong>Phone:</strong></td>
            			                            <td align="left" valign="middle" style="background:#fff; padding:3px;">'.$phone.'</td>
            			                          </tr>
            			              <tr>
            			                            <td align="left" valign="middle" style="background:#fff; padding:3px;"><strong>Message:</strong></td>
            			                            <td align="left" valign="middle" style="background:#fff; padding:3px;">'.$message.'</td>
            			                          </tr>
            			                          
            			                      </table>
            			                      
            			                </div>            
            			            </div>
            			          </body>
            			    </html>';
                
            	    if($mail->send())
            	    {
            	        $data = 1;
            	     
            	    // header("Refresh:0");
            	    }
            	    else
            	    {
            	        $data = 0;
            	     
            	    // header("Refresh:0");
            	     }


	    echo json_encode($data);
	     
	}

}
