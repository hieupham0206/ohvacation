<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 10/12/2016
 * Time: 1:29 PM
 */

namespace common\utils\helpers;

use Yii;

/**
 * Class Mail
 * @property string $content
 * @property string $subject
 * @property string $mailTo
 * @package common\utils\model
 */
class Mail
{
    private $content;
    private $subject;
    private $mailTo;

    /**
     * SendMail constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->content = $params['content'];
        $this->subject = $params['subject'];
        $this->mailTo  = $params['mailTo'];
    }

    public function send($layout = '', array $params = array())
    {
        if ($layout == '') {
            return Yii::$app->mailer->compose()
                                    ->setFrom([Yii::$app->params['supportEmail'] => 'OH Vacation Booking'])
                                    ->setTo($this->mailTo)
                                    ->setSubject($this->subject)
                                    ->setTextBody($this->content)
                                    ->send();
        }

        return Yii::$app->mailer->compose($layout, $params)
                                ->setFrom([Yii::$app->params['supportEmail'] => 'OH Vacation Booking'])
                                ->setTo($this->mailTo)
                                ->setSubject($this->subject)
                                ->send();
    }

    public function sendMultiple($layout = '', array $params = array(), array $emails = array())
    {
        $mails = [];
        foreach ($emails as $email) {
            if ($layout == '') {
                $mails[] = Yii::$app->mailer->compose()
                                            ->setFrom([Yii::$app->params['supportEmail'] => 'OH Vacation Booking' . ' robot'])
                                            ->setTo($email)
                                            ->setSubject($this->subject)
                                            ->setTextBody($this->content)
                                            ->send();
            } else {
                $mails[] = Yii::$app->mailer->compose($layout, $params)
                                            ->setFrom([Yii::$app->params['supportEmail'] => 'OH Vacation Booking' . ' robot'])
                                            ->setTo($email)
                                            ->setSubject($this->subject)
                                            ->send();
            }
        }

        return Yii::$app->mailer->sendMultiple($mails);
    }

}