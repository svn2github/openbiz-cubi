<?php 
class AddressPickerForm extends PickerForm
{
	public function fetchData()
	{
		$result = parent::fetchData();
		$prtFormName = BizSystem::getObject($this->m_ParentFormName)->m_ParentFormName;
		if( $prtFormName=='account.form.AccountEditShippingAddressForm' || 
			$prtFormName=='account.form.AccountEditBillingAddressForm'
			){
			$account_id = BizSystem::getObject(BizSystem::getObject($this->m_ParentFormName)->m_ParentFormName)->m_RecordId;
			$result['account_id'] = $account_id;	
			$productRec = BizSystem::getObject("account.do.AccountPickDO")->fetchById($account_id);			
			$result['account_name'] = $productRec['name'];
		}
		return $result;
	}
		
}
?>