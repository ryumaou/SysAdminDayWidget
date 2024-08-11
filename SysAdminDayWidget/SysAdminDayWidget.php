<?php
/*
Plugin Name: Sysadmin Day WordPress Widget
Plugin URI: https://jkhoffman.com/
Version: 1.01
Description: A simple WordPress Widget to let you know when Sysadmin Day is near, and here! With a link to my Amazon wishlist for IT books and gear for ideas on what a sysadmin might like as a thank you!
Author: J K Hoffman
Author URI: https://JKHoffman.com/
*/

class SysadminDay_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'SysadminDay_Widget',
            'description' => 'Sysadmin Day Widget'
        );
        parent::__construct('SysadminDay_Widget', 'Sysadmin Day Widget', $widget_ops);
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                Title:
                <input 
                    class="widefat" 
                    id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                    type="text" 
                    value="<?php echo esc_attr($title); ?>" 
                />
            </label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        date_default_timezone_set('America/Chicago');
        
        function dateDiffInDays($date1, $date2) {
            $diff = strtotime($date2) - strtotime($date1);
            return abs(round($diff / 86400));
        }
        
        function RandomQuoteByInterval($TimeBase, $QuotesArray) {
            $TimeBase = intval($TimeBase);
            $ItemCount = count($QuotesArray);
            $RandomIndexPos = ($TimeBase % $ItemCount);
            return $QuotesArray[$RandomIndexPos];
        }
        
        $SysAdminYear = (date("n") >= 8) ? date('Y', strtotime('+1 year')) : date("Y");
        $SysAdminDay = "last Friday {$SysAdminYear}-08";
        $myToday = date("l, F jS Y");
        $dateDiff = dateDiffInDays($myToday, $SysAdminDay);
        $DayOfTheYear = date('i');
        $RandomQuotes = array(
            'Thank your sysadmin for all the problems you <b>haven\'t</b> had!',
            'Thank your sysadmin for keeping the network running!',
            'Take your sysadmin out for lunch!',
            'Buy your sysadmin a coffee!',
            'Tell your sysadmin how great your system is running!',
            'Tell your sysadmin how great your network is running!'
        );

        if ($myToday == $SysAdminDay) {
            echo "Today is <a href=\"https://www.sysadminday.com/\">System Administrator's Day</a>! <br> Thank your local SysAdmin!";
            echo "<br>" . RandomQuoteByInterval($DayOfTheYear, $RandomQuotes);
        } elseif ($dateDiff < 30) {
            echo "Today is {$myToday}.<br>";
            echo " <a href=\"https://www.sysadminday.com/\">SysAdmin Day</a> is on " . date("l, F jS, Y", strtotime($SysAdminDay)) . ".<br>";
            echo "Which means you have just {$dateDiff} days to get your system administrator <a href=\"https://www.amazon.com/hz/wishlist/ls/W64F84GW73ID?ref_=wl_share\">a gift</a>!";
        } else {
            echo "Today is {$myToday}.<br>";
            echo " <a href=\"https://www.sysadminday.com/\">SysAdmin Day</a> is on " . date("l, F jS, Y", strtotime($SysAdminDay)) . ".<br>";
            echo "Which means that SysAdmin Day is just {$dateDiff} days away!";
        }
        
        echo $args['after_widget'];
    }
}

function register_sysadmin_day_widget() {
    register_widget('SysadminDay_Widget');
}
add_action('widgets_init', 'register_sysadmin_day_widget');

?>
