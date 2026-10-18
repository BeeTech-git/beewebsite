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
    $this->output->set_content_type('application/json');

    $name = trim((string) $this->input->post('name'));
    $email = trim((string) $this->input->post('email'));
    $message = trim((string) $this->input->post('comments'));
    $verify = trim((string) $this->input->post('verify'));

    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $message === '' ||
        $verify !== '4'
    ) {
        return $this->output->set_output(json_encode([
            'status' => 'error',
            'message' => 'Please check your details and captcha answer.'
        ]));
    }

    try {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 25;
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;

                    $mail->SMTPSecure = "none";
                    $mail->Username = 'beetechnology9@gmail.com';
                    $mail->Password = 'Pp@ssadminbee';
                    // $mail->SMTPDebug = 2;

        // Use a sender address belonging to your domain.
        $mail->setFrom('info@beetechnology.in', 'Bee Technology');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('info@beetechnology.in');

        $mail->Subject = 'Bee Technology - Contact Form';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $safeName = htmlspecialchars(
            $name, ENT_QUOTES, 'UTF-8'
        );
        $safeEmail = htmlspecialchars(
            $email, ENT_QUOTES, 'UTF-8'
        );
        $safeMessage = nl2br(htmlspecialchars(
            $message, ENT_QUOTES, 'UTF-8'
        ));

        $mail->Body = "
            <h2>New Contact Form Enquiry</h2>
            <p><strong>Name:</strong> {$safeName}</p>
            <p><strong>Email:</strong> {$safeEmail}</p>
            <p><strong>Message:</strong><br>{$safeMessage}</p>
        ";

        $mail->AltBody =
            "Name: {$name}\nEmail: {$email}\nMessage: {$message}";

        if (!$mail->send()) {
            throw new Exception('Email delivery failed.');
        }

        return $this->output->set_output(json_encode([
            'status' => 'success',
            'message' => 'Thank you! Your message has been sent successfully.'
        ]));

    } catch (Exception $e) {
        log_message('error', 'Contact form email failed: ' . $e->getMessage());

        return $this->output->set_output(json_encode([
            'status' => 'error',
            'message' => 'Unable to send your message right now. Please try again later.'
        ]));
    }
}

public function subscribe()
{
    $this->output->set_content_type('application/json');

    if ($this->input->method(TRUE) !== 'POST') {
        return $this->output
            ->set_status_header(405)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]));
    }

    $email = strtolower(trim(
        (string) $this->input->post('subscriber_email')
    ));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Please enter a valid email address.'
            ]));
    }

    $existing = $this->db
        ->where('subscriber_email', $email)
        ->get('newsletter_subscribers')
        ->row();

    if ($existing) {
        if ($existing->status === 'subscribed') {
            return $this->output->set_output(json_encode([
                'status' => 'success',
                'message' => 'This email is already subscribed!'
            ]));
        }

        // Reactivate a previously unsubscribed address.
        $this->db
            ->where('id', $existing->id)
            ->update('newsletter_subscribers', [
                'status' => 'subscribed',
                'subscribed_at' => date('Y-m-d H:i:s')
            ]);

        return $this->output->set_output(json_encode([
            'status' => 'success',
            'message' => 'Your subscription has been reactivated!'
        ]));
    }

    $saved = $this->db->insert('newsletter_subscribers', [
        'subscriber_email' => $email,
        'status' => 'subscribed',
        'subscribed_at' => date('Y-m-d H:i:s')
    ]);

    if (!$saved) {
        log_message('error', 'Newsletter subscription database insert failed.');

        return $this->output
            ->set_status_header(500)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Unable to subscribe right now. Please try again later.'
            ]));
    }

    return $this->output->set_output(json_encode([
        'status' => 'success',
        'message' => 'Thank you for subscribing to Bee Technology!'
    ]));
}


// 	public function sendmeform()
// 	{
// 	    $name = $this->input->post('name');
// 	    $email = $this->input->post('email');
// 	    $message = $this->input->post('comments');

// // Load PHPMailer library
//                     $this->load->library('phpmailer_lib');
                    
//                     // PHPMailer object
//                     $mail = $this->phpmailer_lib->load();
                    
//                     $mail->isSMTP(true);
//             	    $mail->Port = 25; 
//             	    $mail->Host = 'localhost';
//             	    $mail->SMTPAuth = false;
//             	    $mail->SMTPAutoTLS = false; 
//                     $mail->SMTPSecure = "none";
//                     $mail->Username = 'beetechnology9@gmail.com';
//                     $mail->Password = 'Pp@ssadminbee';
//                     // $mail->SMTPDebug = 2;
                    
                    
//                     $mail->setFrom($email, $name);
//                     // $mail->addReplyTo('info@example.com', 'CodexWorld');
                    
//                     // Add a recipient
//                     $mail->addAddress('info@beetechnology.in');
                    
//                     // Add cc or bcc 
//                     // $mail->addCC('robert.cloudy@outlook.com');
                    
//                     // Email subject
//               		$mail->Subject = "BEE TECH Contact Form";
                    
//                     // Set email format to HTML
//                     $mail->isHTML(true);
//               		$data = 0;
//               		$mail->Body = '
//             		    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//             		    	<html xmlns="http://www.w3.org/1999/xhtml">
//             			    <head>
//             			      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
//             			      <title>Contact Me Form</title>
//             			    </head>
            	    
//             			    <body style="margin:0; padding:0; font:13px Arial, tahoma, Verdana, Helvetica, sans-serif;">
//             			      <div align="left" style="width:100%; margin:auto; background:#fff; color:#000;">
//             			        <div align="left" style="padding:20px;">
//             			                  <div align="left" style="background:#fff; margin-bottom:15px; font-size:18px; font-weight:bold; color:#000;">Contact Me Form</div>
//             			                        <table width="100%" border="0" cellspacing="1" cellpadding="1" style="background:#ccc;">
//             			                          <tr>
//             			                            <td width="50%" align="left" valign="middle" style="background:#fff; padding:3px;">Name:</td>
//             			                            <td width="50%" align="left" valign="middle" style="background:#fff; padding:3px;">'.$name.'</td>
//             			                          </tr>
//             			              <tr>
//             			                            <td align="left" valign="middle" style="background:#fff; padding:3px;"><strong>Email:</strong></td>
//             			                            <td align="left" valign="middle" style="background:#fff; padding:3px;">'.$email.'</td>
//             			                          </tr>
//             			              <tr>
//             			                            <td align="left" valign="middle" style="background:#fff; padding:3px;"><strong>Phone:</strong></td>
//             			                            <td align="left" valign="middle" style="background:#fff; padding:3px;">'.$phone.'</td>
//             			                          </tr>
//             			              <tr>
//             			                            <td align="left" valign="middle" style="background:#fff; padding:3px;"><strong>Message:</strong></td>
//             			                            <td align="left" valign="middle" style="background:#fff; padding:3px;">'.$message.'</td>
//             			                          </tr>
            			                          
//             			                      </table>
            			                      
//             			                </div>            
//             			            </div>
//             			          </body>
//             			    </html>';
                
//             	    if($mail->send())
//             	    {
//             	        $data = 1;
            	     
//             	    // header("Refresh:0");
//             	    }
//             	    else
//             	    {
//             	        $data = 0;
            	     
//             	    // header("Refresh:0");
//             	     }


// 	    echo json_encode($data);
	     
// 	}

}
