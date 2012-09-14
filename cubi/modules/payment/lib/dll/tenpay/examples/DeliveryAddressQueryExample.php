<?php
//---------------------------------------------------------
//����֧������ʾ��,��������֧������
//---------------------------------------------------------

require_once ("../classes/DeliveryAddressQueryRequest.class.php");
require_once ("tenpay_config.php");


/* ��ʼ��֪ͨ��֤���� */
$DAreqHandler = new DeliveryAddressQueryRequest($key);

// ������ɳ�������У���ʽ����������Ϊfalse
$DAreqHandler->setInSandBox(true);
//----------------------------------------
//����ҵ��������Ʋο�����ƽ̨sdk�ĵ�-PHP
//----------------------------------------

// ���òƸ�ͨappid: �Ƹ�ͨappע��ʱ���ɲƸ�ͨ����
$DAreqHandler->setAppid($appid);

// �����û�token, ����ͨ��ShareLoginState���getToken()�������, ����μ�ShareLoginState��getToken()����
$DAreqHandler->setParameter("token", "F9E2B324183DDD1F65A9E0D60191BD3F1DF62A7A0B0F9B1990A7346A7A30495E3FB0148BD6E61E99658EAE042A246F08");
      
// �������󣬲���ȡ���ض���
$DAresponse = $DAreqHandler->send();
// �жϷ����Ƿ�ɹ�
if($DAresponse->isRetCodeOK()) {
	// �õ��û��ջ���ַ�б�
	$addressInfoList = $DAresponse->getDeliveryAddresss();
	foreach($addressInfoList as $addressInfo) //ѭ����ȡÿһ���ӽڵ�
	{
		// ��ַ��Ϣ
		echo $addressInfo->getAddress(). "<br/>";
		// �ֻ�����
		echo $addressInfo->getMobilePhone(). "<br/>";
		// ����
		echo $addressInfo->getName(). "<br/>";
		// �̶��绰
		echo $addressInfo->getTelPhone(). "<br/>";
		// �ʱ�
		echo $addressInfo->getZipCode(). "<br/>";
	}
}else{
    echo "��ѯ�û��ջ���ַʧ��." . "<br/>";
}

?>