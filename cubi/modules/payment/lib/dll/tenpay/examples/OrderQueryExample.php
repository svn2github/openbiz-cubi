<?php
//---------------------------------------------------------
//�����̻������Ż��߲Ƹ�ͨ�����Ų�ѯ�Ƹ�ͨ���¼�ľ��嶩����Ϣ
//---------------------------------------------------------

require_once ("../classes/OrderQueryRequest.class.php");
require_once ("tenpay_config.php");


// ��ʼ��������ѯ����:�����̻������Ż��߲Ƹ�ͨ�����Ų�ѯ�Ƹ�ͨ���¼�ľ��嶩����Ϣ.
$ordHandler = new OrderQueryRequest($key);

// ������ɳ�������У���ʽ����������Ϊfalse
$ordHandler->setInSandBox(true);

//----------------------------------------
//��������ҵ��������Ʋο�����ƽ̨sdk�ĵ�-PHP
//----------------------------------------

// ���òƸ�ͨApp-id: �Ƹ�ͨAppע��ʱ���ɲƸ�ͨ����
$ordHandler->setAppid($appid);		

// ���òƸ�ͨApp������:�Ƹ�ͨAPP�Ķ�����
$ordHandler->setParameter("out_trade_no", "test100000001");    
// **********************end*************************

// �������󣬲���ȡ���ض���
$Response = $ordHandler->send();
// ********************���·���ҵ��������Ʋο�����ƽ̨sdk�ĵ�-PHP*************************
if($Response->isPayed()) {// �Ѿ�֧��
	// �Ѿ�֧���Ƹ�ͨapp������
	echo "֧���ɹ���Ӧ�ö����ţ�" . $Response->getParameter("out_trade_no") . "<br/>";
	// �Ƹ�ͨapp�����Ŷ�Ӧ�ĲƸ�ͨ������
	echo "�Ƹ�ͨ������:" . $Response->getParameter("transaction_id") . "<br/>";
	// ֧������λ����
	echo "֧�����:" . $Response->getParameter("total_fee") . "<br/>";
	// ֧�����ʱ��,��ʽΪyyyymmddhhmmss,��20091227091010
	echo "֧�����ʱ��:" . $Response->getParameter("time_end") . "<br/>";
}else{// δ����֧�������ߵ����쳣������ó�ʱ�������쳣
    echo "֧��״̬˵��:" . $Response->getPayInfo() . "<br/>";
}


?>
