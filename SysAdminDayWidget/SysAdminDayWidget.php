<?php
/*
Plugin Name: Sysadmin Day WordPress Widget
Plugin URI: https://jkhoffman.com/
Version: .9
Description: A simple WordPress Widget to let you know when Sysadmin Day is near, and here! With a link to my Amazon wishlist for IT books and gear for ideas on what a sysadmin might like as a thank you!
Author: J K Hoffman
Author URI: https://JKHoffman.com/
*/
 
class SysadminDay_Widget extends WP_Widget
{
  function SysadminDay_Widget()
  {
    $widget_ops = array('classname' => 'SysadminDay_Widget', 'description' => 'Sysadmin Day Widget');
    $this->WP_Widget('SysadminDay_Widget', 'Sysadmin Day Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args((array) $instance, array( 'title' => '' ));
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class='widefat' id='<?php echo $this->get_field_id('title'); ?>' name='<?php echo $this->get_field_name('title'); ?>' type='text' value='<?php echo attribute_escape($title); ?>' /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
    
date_default_timezone_set('America/Chicago');
# echo "The timezone being used is " . date_default_timezone_get(); echo "<br>";


function dateDiffInDays($date1, $date2)  
{ 
    // Calculating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
} 
function RandomQuoteByInterval($TimeBase, $QuotesArray){
 
    // Make sure it is a integer
    $TimeBase = intval($TimeBase);
 
    // How many items are in the array?
    $ItemCount = count($QuotesArray);
 
    // By using the modulus operator we get a pseudo
    // random index position that is between zero and the
    // maximal value (ItemCount)
    $RandomIndexPos = ($TimeBase % $ItemCount);
 
    // Now return the random array element
    return $QuotesArray[$RandomIndexPos];
}
  
 if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // Do Your Widgety Stuff Here...
    // echo "<center><h3>Quote of the Day</h3>";
    //echo "The time is " . date("h:i:sa");
    //echo "<br>";
    
if (date("n")>=8){
	$SysAdminYear = date('Y', strtotime('+1 year'));
#	echo $SysAdminYear . "<br>";
	}else{
	$SysAdminYear = date("Y");
}

$SysAdminDay = "last Friday ".$SysAdminYear."-08";
$myToday = date("l, F jS Y");
// Function call to find date difference 
$dateDiff = dateDiffInDays($myToday, $SysAdminDay); 
$DayOfTheYear = date('i'); 
// You could also use:
//  --> date('m'); // Quote changes every month
//  --> date('z'); // Quote changes every day
//  --> date('h'); // Quote changes every hour
//  --> date('i'); // Quote changes every minute
$RandomQuotes = array(
    'Thank your sysadmin for all the problems you <b>haven\'t</b> had!',
    'Thank your sysadmin for keeping the network running!',
    'Take your sysadmin out for lunch!',
    'Buy your sysadmin a coffee!',
    'Tell your sysadmin how great your system is running!', 
    'Tell your sysadmin how great your network is running!',     
);

if ($myToday == $SysAdminDay){
	echo "Today is  <a href=\"https://www.sysadminday.com/\">System Administrator's Day</a>! <br> Thank your local SysAdmin!";
	echo "<br>".RandomQuoteByInterval($DayOfTheYear, $RandomQuotes);
}elseif ($dateDiff < 30) {
echo "Today is ".$myToday.".<br>";
echo " <a href=\"https://www.sysadminday.com/\">SysAdmin Day</a> is on ".date("l, F jS, Y", strtotime($SysAdminDay)).".<br>";
# echo date("l, M-d-Y", strtotime($SysAdminDay));
echo "Which means you have just ".$dateDiff." days to get your system administrator <a href=\"https://www.amazon.com/hz/wishlist/ls/W64F84GW73ID?ref_=wl_share\">a gift</a>!";
}else{
	echo "Today is ".$myToday.".<br>";
echo " <a href=\"https://www.sysadminday.com/\">SysAdmin Day</a> is on ".date("l, F jS, Y", strtotime($SysAdminDay)).".<br>";
# echo date("l, M-d-Y", strtotime($SysAdminDay));
echo "Which means that SysAdmin Day is just ".$dateDiff." days away!";

}
    echo "</center>";
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("SysadminDay_Widget");') );

?>
