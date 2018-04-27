<?php

namespace app\controller;

include_once ROOT_DIR . '/extends/aliyun-php-sdk-dm/aliyun-php-sdk-core/Config.php';

use app\Controller;
use Dm\Request\V20151123 as Dm;
use pms\Output;

/**
 *  测试控制器
 * Class Demo
 * @package app\controllers
 */
class Sende extends Controller
{

    /**
     * 发送邮件
     */
    public function send2()
    {
        $data = $this->getData();

        //需要设置对应的region名称，如华东1（杭州）设为cn-hangzhou，新加坡Region设为ap-southeast-1，澳洲Region设为ap-southeast-2。
        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", get_env('aliyun_dm_accessKey'), get_env('aliyun_dm_accessSecret'));
        //新加坡或澳洲region需要设置服务器地址，华东1（杭州）不需要设置。
        //$iClientProfile::addEndpoint("ap-southeast-1","ap-southeast-1","Dm","dm.ap-southeast-1.aliyuncs.com");
        //$iClientProfile::addEndpoint("ap-southeast-2","ap-southeast-2","Dm","dm.ap-southeast-2.aliyuncs.com");
        $client = new \DefaultAcsClient($iClientProfile);
        $request = new Dm\SingleSendMailRequest();
        //新加坡或澳洲region需要设置SDK的版本，华东1（杭州）不需要设置。
        //$request->setVersion("2017-06-22");
        $request->setAccountName(get_env('aliyun_dm_accountName'));
        $request->setAddressType(1);
        $request->setTagName(get_env('aliyun_dm_tagName'));
        $request->setReplyToAddress("true");
        $request->setFromAlias(get_env('aliyun_dm_nickname', "昵称"));
        $request->setToAddress($data['email']);
        $request->setSubject($data['title']);
        $request->setHtmlBody($data['content']);
        try {
            $response = $client->getAcsResponse($request);
            Output::info($response, 'send_ok');
            # 成功
            $this->connect->send_succee($response->EnvId, '发送成功');
        } catch (\ClientException  $e) {
            Output::error([$e->getErrorCode(), $e->getErrorMessage()], 'ClientException');
            $this->connect->send_error('发送失败', [$e->getErrorCode(), $e->getErrorMessage()]);
        } catch (\ServerException  $e) {
            Output::error([$e->getErrorCode(), $e->getErrorMessage()], 'ServerException');
            $this->connect->send_error('发送失败', [$e->getErrorCode(), $e->getErrorMessage()]);
        }
    }

}