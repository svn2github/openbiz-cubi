<?PHP
/**
 * PHPOpenBiz
 *
 * @author     Rocky Swen <rocky@phpopenbiz.org>
 * @version    2.3 2009-06-01 
 */

class visService
{
    public static function self($userIdField)
    {
        // get current $user_id
        $userProfile = BizSystem::getUserProfile();
        if (!$userProfile)
            return "";
        $userId = $userProfile['Id'];
        
        // return "[$userIdField] = '$userId'"
        return "[$userIdField]='$userId'";
    }
    
    public static function group($groupIdField)
    {
        // get current user's group list
        $userProfile = BizSystem::getUserProfile();
        //print_r($userProfile);
        if (!$userProfile ||!$userProfile['groups'])
            return "[".$groupIdField."] is null";
        $userId = $userProfile['Id'];
        $groupList = implode(",", $userProfile['groups']);
        
        return "[".$groupIdField."] in (".$groupList.")";
    }
    
    public static function self_group($userIdField, $groupIdField)
    {
        $selfRule = self::self($userIdField);
        $groupRule = self::group($groupIdField);
        
        return "($selfRule OR $groupRule)";
    }
        
    public static function custom($dataObj)
    {
    }
}