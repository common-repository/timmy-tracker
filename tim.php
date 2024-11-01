<?php
/**
 * @package timmy-tracker
 * @author jtclark
 * @version 1.0
 */
/*
Plugin Name: Timmy Tracker
Plugin URI: http://blog.jtclark.ca/timmy-tracker
Description: Track your Tim Hortons Roll Up The Rim To Win Contest Statistics
Author: John Thomas Clark
Version: 1.0
Author URI: http://blog.jtclark.ca
*/

class TimmyTrackerWidget extends WP_Widget
{
    /**
     * Declares the TimmyTrackerWidget class.
     *
     */
    function TimmyTrackerWidget(){
        
        $widget_ops = array(
            'classname'     => 'widget_timmy_tracker', 
            'description'   => __( "Track your Tim Horton's Roll Up The Rim To Win Contest Statistics") 
        );
        
        $control_ops = array(
        );
        
        $this->WP_Widget('timmytracker', __('Timmy Tracker'), $widget_ops, $control_ops);
    }

    /**
     * Displays the Widget
     *
     */
    function widget($args, $instance){
        extract($args);
        
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
        $showTable = empty($instance['showTable']) ? '0' : $instance['showTable'];
        
        $extraLargePurchases = empty($instance['extraLargePurchases']) ? '0' : $instance['extraLargePurchases'];
        $extraLargeWins      = empty($instance['extraLargeWins']) ? '0' : $instance['extraLargeWins'];
        $extraLargeLosses    = $extraLargePurchases - $extraLargeWins;
        
        $largePurchases      = empty($instance['largePurchases']) ? '0' : $instance['largePurchases'];
        $largeWins           = empty($instance['largeWins']) ? '0' : $instance['largeWins'];
        $largeLosses         = $largePurchases - $largeWins;
        
        $mediumPurchases     = empty($instance['mediumPurchases']) ? '0' : $instance['mediumPurchases'];
        $mediumWins          = empty($instance['mediumWins']) ? '0' : $instance['mediumWins'];
        $mediumLosses        = $mediumPurchases - $mediumWins;
        
        $smallPurchases      = empty($instance['smallPurchases']) ? '0' : $instance['smallPurchases'];
        $smallWins           = empty($instance['smallWins']) ? '0' : $instance['smallWins'];
        $smallLosses         = $smallPurchases - $smallWins;
        
        $totalPurchases      = $smallPurchases + $mediumPurchases + $largePurchases + $extraLargePurchases;
        $totalWins           = $smallWins + $mediumWins + $largeWins + $extraLargeWins;
        $totalLosses         = $smallLosses + $mediumLosses + $largeLosses + $extraLargeLosses;
        
        # Before the widget
        echo $before_widget;

        # The title
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        # Make the Hello World Example widget
        echo '<div style="text-align:center;padding:0px;">' . 
        
        rollUpStatistics(array(
            'showTable'           => $showTable,
            'smallPurchases'      => $smallPurchases,
            'smallWins'           => $smallWins,
            'smallLosses'         => $smallLosses,
            'mediumPurchases'     => $mediumPurchases,
            'mediumWins'          => $mediumWins,
            'mediumLosses'        => $mediumLosses,
            'largePurchases'      => $largePurchases,
            'largeWins'           => $largeWins,
            'largeLosses'         => $largeLosses,
            'extraLargePurchases' => $extraLargePurchases,
            'extraLargeWins'      => $extraLargeWins,
            'extraLargeLosses'    => $extraLargeLosses,
            'totalPurchases'      => $totalPurchases,
            'totalWins'           => $totalWins,
            'totalLosses'         => $totalLosses
        )) . "</div>";
        //echo rollUpStatistics();

        # After the widget
        echo $after_widget;
    }

    /**
     * Saves the widgets settings.
     *
     */
    function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['showTable'] = strip_tags(stripslashes($new_instance['showTable']));
        
        $instance['smallPurchases']      = strip_tags(stripslashes($new_instance['smallPurchases']));
        $instance['mediumPurchases']     = strip_tags(stripslashes($new_instance['mediumPurchases']));
        $instance['largePurchases']      = strip_tags(stripslashes($new_instance['largePurchases']));
        $instance['extraLargePurchases'] = strip_tags(stripslashes($new_instance['extraLargePurchases']));
        
        $instance['smallWins']      = strip_tags(stripslashes($new_instance['smallWins']));
        $instance['mediumWins']     = strip_tags(stripslashes($new_instance['mediumWins']));
        $instance['largeWins']      = strip_tags(stripslashes($new_instance['largeWins']));
        $instance['extraLargeWins'] = strip_tags(stripslashes($new_instance['extraLargeWins']));
        
        return $instance;
    }

    /**
     * Creates the edit form for the widget.
     *
     */
    function form($instance){
        //Defaults
        $instance = wp_parse_args( (array) $instance, array('title'=>'','showTable'=>'1') );

        $title      = htmlspecialchars($instance['title']);
        $showTable  = htmlspecialchars($instance['showTable']);
        
        $smallPurchases      = htmlspecialchars($instance['smallPurchases']);
        $mediumPurchases     = htmlspecialchars($instance['mediumPurchases']);
        $largePurchases      = htmlspecialchars($instance['largePurchases']);
        $extraLargePurchases = htmlspecialchars($instance['extraLargePurchases']);
        
        $smallWins      = htmlspecialchars($instance['smallWins']);
        $mediumWins     = htmlspecialchars($instance['mediumWins']);
        $largeWins      = htmlspecialchars($instance['largeWins']);
        $extraLargeWins = htmlspecialchars($instance['extraLargeWins']);
                

        # Output the options
        
        
        echo '<p style="text-align: left;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 175px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
        echo '<p style="text-align: left;"><label for="' . $this->get_field_name('showTable') . '">' . __('Show Table?') . ' <input id="' . $this->get_field_id('showTable') . '" name="' . $this->get_field_name('showTable') . '" type="checkbox" value="1" ' . (($showTable == 1) ? 'checked':'') . ' /></label></p>';
        ?>
        <table>
          <tbody>
            <tr>
              <td style="font-weight: bold;" colspan="2">Small</td>
            </tr>
            <tr>
              <td style="width: 100px;"><label for="<?= $this->get_field_name('smallPurchases') ?>"><?= __('Purchases:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('smallPurchases') ?>" name="<?= $this->get_field_name('smallPurchases') ?>" type="text" value="<?= $smallPurchases ?>" /></td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('smallWins') ?>"><?= __('Wins:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('smallWins') ?>" name="<?= $this->get_field_name('smallWins') ?>" type="text" value="<?=  $smallWins ?>" /></td>
            </tr>
            <tr>
              <td style="font-weight: bold;" colspan="2">Medium</td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('mediumPurchases') ?>"><?= __('Purchases:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('mediumPurchases') ?>" name="<?= $this->get_field_name('mediumPurchases') ?>" type="text" value="<?= $mediumPurchases ?>" /></td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('mediumWins') ?>"><?= __('Wins:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('mediumWins') ?>" name="<?= $this->get_field_name('mediumWins') ?>" type="text" value="<?=  $mediumWins ?>" /></td>
            </tr>
            <tr>
              <td style="font-weight: bold;" colspan="2">Large</td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('largePurchases') ?>"><?= __('Purchases:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('largePurchases') ?>" name="<?= $this->get_field_name('largePurchases') ?>" type="text" value="<?= $largePurchases ?>" /></td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('largeWins') ?>"><?= __('Wins:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('largeWins') ?>" name="<?= $this->get_field_name('largeWins') ?>" type="text" value="<?=  $largeWins ?>" /></td>
            </tr>        
            <tr>
              <td style="font-weight: bold;" colspan="2">Extra Large</td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('extraLargePurchases') ?>"><?= __('Purchases:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('extraLargePurchases') ?>" name="<?= $this->get_field_name('extraLargePurchases') ?>" type="text" value="<?= $extraLargePurchases ?>" /></td>
            </tr>
            <tr>
              <td><label for="<?= $this->get_field_name('extraLargeWins') ?>"><?= __('Wins:') ?></label></td> 
              <td><input style="width: 50px;" id="<?= $this->get_field_id('extraLargeWins') ?>" name="<?= $this->get_field_name('extraLargeWins') ?>" type="text" value="<?=  $extraLargeWins ?>" /></td>
            </tr>        
                    
          </tbody>
        </table>
        <?php 
        
    }

}// END class

/**
 * Register Timmy TTracker widget.
 *
 * Calls 'widgets_init' action after the Timmy Tracker widget has been registered.
 */
function TimmyTrackerInit() {
    register_widget('TimmyTrackerWidget');
}
  add_action('widgets_init', 'TimmyTrackerInit');


function rollUpStatistics(array $data)
{
    ?>
<style>
table.timtable th {
    padding:1px;
    font-size: 8pt; 
    text-align: center;
}
table.timtable td {padding:1px;font-size: 10pt; text-align: center;}
table.timtable th.cup-sizes {
    font-size: 10pt;
}
</style>
<div style="width: 250px; height:24px; padding-top:160px; background: transparent url('/wp-content/plugins/timmy-tracker/roll.gif') no-repeat;">
<div class="centerplease"  style="width: 100%;text-align: center; color: black;  font-size: 30px; font-weight: bold;">
<?= $data['totalWins'] ?> for <?= $data['totalPurchases'] ?>
</div>
</div>
<?php if ($data['showTable'] == 1) : ?>
<table class="timtable" style="float: left;width: 100%;text-align: center;">
  <thead>
    <tr>
      <th>Size</th>
      <th>Purchases</th>
      <th>Wins</th>
      <th>Losses</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th class="cup-sizes">S</th>
      <td><?= $data['smallPurchases'] ?></td>
      <td><?= $data['smallWins'] ?></td>
      <td><?= $data['smallLosses'] ?></td>
    </tr>
    <tr>
      <th class="cup-sizes">M</th>
      <td><?= $data['mediumPurchases'] ?></td>
      <td><?= $data['mediumWins'] ?></td>
      <td><?= $data['mediumLosses'] ?></td>
    </tr>
    <tr>
      <th class="cup-sizes">L</th>
      <td><?= $data['largePurchases'] ?></td>
      <td><?= $data['largeWins'] ?></td>
      <td><?= $data['largeLosses'] ?></td>
    </tr>
    <tr>
      <th class="cup-sizes">XL</th>
      <td><?= $data['extraLargePurchases'] ?></td>
      <td><?= $data['extraLargeWins'] ?></td>
      <td><?= $data['extraLargeLosses'] ?></td>
    </tr>
    <tr>
      <th>Total</th>
      <td><b><?= $data['totalPurchases'] ?></b></td>
      <td><b><?= $data['totalWins'] ?></b></td>
      <td><b><?= $data['totalLosses'] ?></b></td>
    </tr>
  </tbody>
</table>
<?php endif; ?>
<?php
 
}



