<?php

require_once ('../classes/WapPayRequest.class.php');

/**
 * ����֧������ʾ��,��������֧������
 * 
 * @author marcyli
 * @date 2011-05-11
 * @php5
 * @version 1.0
 */

// ǩ����Կ: ������ע��ʱ�ɲƸ�ͨ����
$secretKey = '28361125644222151345528281136580';
// ����֧���������
$req = new WapPayRequest($secretKey);
// ������ɳ�������У���ʽ����������Ϊfalse
$req->setInSandBox(true);
// ���òƸ�ͨappid: �Ƹ�ͨappע��ʱ���ɲƸ�ͨ����
$req->setAppid('0000000994');

// *************************����ҵ��������Ʋο�����ƽ̨sdk�ĵ�-JAVA****************************
// ���ö����ܽ���λΪ��
$req->setParameter('total_fee', '1');

// ������Ʒ����:��Ʒ����������ʾ�ڲƸ�֧ͨ��ҳ����
$req->setParameter('body', 'test������Ʒ');

// ����֪ͨurl�����ղƸ�ͨ��̨֪ͨ��URL���û��ڲƸ�ͨ���֧���󣬲Ƹ�ͨ��ص���URL����Ƹ�ͨAPP����֧�������
// ��URL���ܻᱻ��λص�������ȷ��������ҵ���߼�����δ������������·�������磺http://wap.isv.com/notify.asp
$req->setParameter('notify_url', 'http://localhost/sdktest/NotifyServlet');

// �����̻�ϵͳ�����ţ��Ƹ�ͨAPPϵͳ�ڲ��Ķ�����,32���ַ��ڡ��ɰ�����ĸ,ȷ���ڲƸ�ͨAPPϵͳΨһ
//app�����Ÿ�����Ҫ�Զ������ɹ��򣬱���ʹ��uuid������
$req->setParameter('out_trade_no', '12345678901234567890');

// ���÷���url���û����֧������ת��URL���Ƹ�ͨAPPӦ�ڴ�ҳ���ϸ�����ʾ��Ϣ�������û����֧����Ĳ�����
// �Ƹ�ͨAPP��Ӧ�ڴ�ҳ������������ҵ������������û�����ˢ��ҳ�浼�¶�δ���ҵ���߼���ɲ���Ҫ����ʧ��
// �������·�������磺http://wap.isv.com/after_pay.asp��ͨ����·��ֱ�ӽ�֧�������Get�ķ�ʽ����
$req->setParameter('return_url', 'http://localhost/sdktest/ReturnServlet');
// �����û��ͻ���ip:�û�IP��ָ�û��������IP�����ǲƸ�ͨAPP������IP
$req->setParameter('spbill_create_ip', $_SERVER['REMOTE_ADDR']);

// ����request_token
$req->setParameter('request_token', $_GET['request_token']);
// *************************************end**************************************************

// ���ƴ�ӡ���ӵ��������
/*try {
	echo $req->getURL();
} catch (Exception $e) {
	//�����쳣
	echo $e;
}*/
header('text/vnd.wap.wml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="֧��">
<p><a href="<?echo $req->getURL();?>">֧��</a>
</p>
</card>
</wml>