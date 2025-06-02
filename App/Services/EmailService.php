<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Core\Env;

class EmailService
{
    protected string $host;
    protected int $port;
    protected string $username;
    protected string $password;
    protected string $encryption;
    protected string $fromAddress;
    protected string $fromName;

    public function __construct()
    {
        $this->host        = Env::get('MAIL_HOST', 'smtp.gmail.com');
        $this->port        = (int) Env::get('MAIL_PORT', 587);
        $this->username    = Env::get('MAIL_USERNAME');
        $this->password    = Env::get('MAIL_PASSWORD');
        $this->encryption  = Env::get('MAIL_ENCRYPTION', 'tls');
        $this->fromAddress = Env::get('MAIL_FROM_ADDRESS', 'no-reply@example.com');
        $this->fromName    = Env::get('MAIL_FROM_NAME', 'Your App');
    }

    /**
     * Send an email using SMTP (PHPMailer)
     *
     * @param string $to
     * @param string $subject
     * @param string $htmlBody
     * @return bool
     */
    public function send(string $to, string $subject, string $htmlBody): bool
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP server settings
            $mail->isSMTP();
            $mail->Host       = $this->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;
            $mail->SMTPSecure = $this->encryption;
            $mail->Port       = $this->port;

            // Email content
            $mail->setFrom($this->fromAddress, $this->fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;

            $mail->send();
            return true;
        } catch (Exception $e) {
    error_log("PHPMailer Error: " . $mail->ErrorInfo);
    return false;
}

    }
}
