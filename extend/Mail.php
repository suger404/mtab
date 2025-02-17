<?php

use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;
use \app\model\SettingModel;

class Mail
{
    public static function send($to = "", $text = ""): bool
    {
        $mail = new Message;
        $send_mail = SettingModel::Config('smtp_email');
        $mail->setFrom(SettingModel::Config('title', '') . " <$send_mail>")
            ->addTo($to)
            ->setSubject(SettingModel::Config('title', '') . '动态令牌')
            ->setHtmlBody($text);
        $option = [
            'port' => SettingModel::Config('smtp_port'),
            'host' => SettingModel::Config('smtp_host'),
            'username' => SettingModel::Config('smtp_email'),
            'password' => SettingModel::Config('smtp_password'),
        ];
        if ((int)$option['port'] === 465) {
            $option['secure'] = 'ssl';
        }
        $mailer = new SmtpMailer($option);
        $mailer->send($mail);
        return true;
    }

    public static function testMail($to, $config): bool
    {
        $mail = new Message;
        $send_mail = $config['smtp_email'];
        $mail->setFrom("测试邮件 <$send_mail>")
            ->addTo($to)
            ->setSubject('测试邮件')
            ->setHtmlBody("这是一个测试邮件");
        $option = [
            'port' => $config['smtp_port'],
            'host' => $config['smtp_host'],
            'username' => $config['smtp_email'],
            'password' => $config['smtp_password'],
        ];
        if ((int)$option['port'] === 465) {
            $option['secure'] = 'ssl';
        }
        $mailer = new SmtpMailer($option);
        $mailer->send($mail);
        return true;
    }
}
