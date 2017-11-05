<?php
/**
 * Created by PhpStorm.
 * User: ningjian
 * Date: 2017/11/5
 * Time: 22:09
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WechatCallbackController extends Controller
{
    public function index()
    {
        //΢�Ź��ںŽӿڵ�һ�ν��룬��֤��ԭ������
        if (isset($_REQUEST['echostr'])) {
            $this->valid();
        } else {
        }
    }

    private function valid(){
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        //��ȡ��ʱToken
        $token = config('temp.Token', 'ningjian');

        if ($this->checkSignature($token, $signature, $timestamp, $nonce)) {
            // ob_clean(); //������ţ��
            // header('content-type:text'); //������ţ��
            echo $_REQUEST["echostr"];
            exit;
        }
    }

    public function index2(Request $request)
    {
        $xmlObj = $request->get('xmlObj');
        //��Ϣ����
        $RX_TYPE = trim($xmlObj->MsgType);
        switch ($RX_TYPE) {
            case "text":
                $resultStr = $this->receiveText($xmlObj);
                break;
            case "image":
                $resultStr = $this->receiveImage($xmlObj);
                break;
            case "voice":
                $resultStr = $this->receiveVoice($xmlObj);
                break;
            case "video":
                $resultStr = $this->receiveVideo($xmlObj);
                break;
            case "shortvideo":
                $resultStr = $this->receiveShortVideo($xmlObj);
                break;
            case "location":
                $resultStr = $this->receiveLocation($xmlObj);
                break;
            case "link":
                $resultStr = $this->receiveLink($xmlObj);
                break;
            case "event":
                $resultStr = $this->receiveEvent($xmlObj);
                break;
            default:
                $resultStr = "unknow msg type: " . $RX_TYPE;
                break;
        }

        echo $resultStr;
    }

    /**
     * �����ı���Ϣ
     * @param $object
     * @return string
     */
    private function receiveText($object)
    {
        //�ж���Ϣ�Ƿ��ظ�
//        if ($this->msgRepeated($object)) {
//            return "";
//        }

        //���ݹؼ��ʴ�Redis
        $fromUserName = $object->FromUserName;
        $content = $object->Content;
        if (strcasecmp($content, 'openid') == 0) {
            //�����û�OPENID
            $contentStr = $fromUserName;
            $resultStr = $this->transmitText($object, $contentStr);
        } else {
            //���������������ò��ˣ�����XML̫��ʱ��
            $tw = new WeatherApiTest();
            $contentStr = $tw->getWeatherInfo($content);
            $resultStr = $this->transmitText($object, $contentStr);
        }
        //����XML�ַ���
        return $resultStr;
    }

    /**
     * �����¼�����ע��
     * @param $object
     * @return string
     */
    private function receiveEvent($object)
    {
        //�ж���Ϣ�Ƿ��ظ�
        if ($this->msgRepeated($object)) {
            return "";
        }

        $contentStr = "";
        switch ($object->Event) {
            case "subscribe":
                $title = "��ã�����666������ҡҡ��"; //��ע��ظ�����
                $contentStr = $this->transmitText($object, $title);
                break;
            case "unsubscribe":
                $contentStr = "ȡ���ɹ�";
                $this->unsubscribe($object);
                break;
            case "LOCATION":
                $contentStr = $this->receiveClick($object); //����¼�
                break;
            case "CLICK":
                $contentStr = $this->receiveClick($object); //����¼�
                break;
            case "VIEW":
                $contentStr = $this->receiveClick($object); //����¼�
                break;
            default:
                $contentStr = "receive a new event: " . $object->Event;
                break;
        }
        //����XML�ַ���
        return $contentStr;
    }
}