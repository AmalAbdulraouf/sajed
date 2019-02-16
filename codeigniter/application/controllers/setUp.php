<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller{

	#index
	public function index()
	{
		
		
	/*	//for closed orders
		$this->db->select('actions.orders_id');
		$this->db->from('actions');
		$this->db->where('status_id', 6);
		$orders = $this->db->get();
		$orders =$orders->result();
		foreach ($orders as $order) 
		{
			$this->db->where('id', $order->orders_id);
			$this->db->update('orders', array('current_status_id'=> 6));
		}
		
		
		//for ready orders
		$this->db->select('actions.orders_id');
		$this->db->from('actions');
		$this->db->where('status_id', 5);
		$orders = $this->db->get();
		$orders =$orders->result();
		foreach ($orders as $order) 
		{
			$this->db->where('id', $order->orders_id);
			$this->db->update('orders', array('current_status_id'=> 5));
		}
		
		
		
		//for cancelled orders
		$this->db->select('actions.orders_id');
		$this->db->from('actions');
		$this->db->where('status_id',4);
		$orders = $this->db->get();
		$orders =$orders->result();
		foreach ($orders as $order) 
		{
			$this->db->where('id', $order->orders_id);
			$this->db->update('orders', array('current_status_id'=> 4));
		}
		
		
		
		//update actions table
		$query = "ALTER TABLE actions ADD  `repair_cost` decimal(11,0) DEFAULT '0' after `description`";
		$this->db->query($query);
		
		$query = "ALTER TABLE actions ADD  `spare_parts_cost` int(11) NOT NULL DEFAULT '0' after `repair_cost`";
		$this->db->query($query);
		
		$query = "ALTER TABLE actions DROP COLUMN cost ";
		$this->db->query($query);
		
		
		
		//create additions table
		$query = "	
		CREATE TABLE IF NOT EXISTS `additions` 
		(
  			`id` int(11) NOT NULL AUTO_INCREMENT,
  			`name` varchar(60) NOT NULL,
  			PRIMARY KEY (`id`)
		) 
		ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		$this->db->query($query);
		
		
		
		//add IDnum to contacts 
		$query = "ALTER TABLE contacts ADD  `IDnum` int(11) DEFAULT NULL after `email`";
		$this->db->query($query);
		
		
		
		//Create emails_options table
		$query = "	
		CREATE TABLE IF NOT EXISTS `emails_options` 
		(
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `option_name` varchar(50) NOT NULL,
		  `option_value` int(11) NOT NULL DEFAULT '1',
		  `option_text` text NOT NULL,
		  `option_lang` varchar(3) NOT NULL,
		  PRIMARY KEY (`id`)
		) 
		ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		$this->db->query($query);
		
		
		
		
		//create excuses table
		$query = "	
		CREATE TABLE IF NOT EXISTS `excuses` 
		(
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `tech_id` int(11) NOT NULL,
		  `order_id` int(11) NOT NULL,
		  `excuse` varchar(200) NOT NULL,
		  `date` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) 
		ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		$this->db->query($query);
		
		
		
		//create option additions table 
		$query = "	
		CREATE TABLE IF NOT EXISTS `options_additions` 
		(
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `add_id` int(11) NOT NULL,
		  `option_name` varchar(50) NOT NULL,
		  `value` tinyint(1) NOT NULL DEFAULT '1',
		  PRIMARY KEY (`id`)
		) 
		ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		$this->db->query($query);
		
		
		
		//create option additions emails table 
		$query = "	
		CREATE TABLE IF NOT EXISTS `options_additions_emails` 
		(
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `add_id` int(11) NOT NULL,
		  `option_name` varchar(50) NOT NULL,
		  `value` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) 
		ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		$this->db->query($query);
		
		
		
		//add columns to orders
		$query = "ALTER TABLE orders ADD  `external_repair` tinyint(1) NOT NULL DEFAULT '0' after `fault_description`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `examine_cost` int(11) NOT NULL DEFAULT '0' after `estimated_cost`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `delivery_date` int(11) NOT NULL COMMENT 'how many days to delivery' after `examine_cost`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `examine_date` int(11) NOT NULL COMMENT 'examine date that is expected.' after `delivery_date`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `repair_cost` int(11) NOT NULL DEFAULT '0' after `color_id`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `spare_parts_cost` int(11) NOT NULL DEFAULT '0' after `repair_cost`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `Receipt` tinyint(1) NOT NULL DEFAULT '1' after `spare_parts_cost`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `place` varchar(20) DEFAULT NULL after `Receipt`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD `billNumber` int(11) DEFAULT NULL after `place`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `billDate` date DEFAULT NULL after `billNumber`";
		$this->db->query($query);
		
		$query = "ALTER TABLE orders ADD  `last_excuse_id` int(11) DEFAULT NULL after `billDate`";
		$this->db->query($query);
		
		
		
		//update users table
		$query = "ALTER TABLE users ADD `Activated` tinyint(1) NOT NULL DEFAULT '1' after `contacts_id`";
		$this->db->query($query);
		
		$query = "ALTER TABLE users ADD `Absent` tinyint(1) NOT NULL DEFAULT '0' after `Activated`";
		$this->db->query($query);
		
		
		
		//create options
		$query =" DROP TABLE options";
		$this->db->query($query);
		
		$query = "
		CREATE TABLE IF NOT EXISTS `options`
		(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`option_name` varchar(50) NOT NULL,
			`option_value` varchar(45) DEFAULT '1',			
			`option_text` text CHARACTER SET utf8 NOT NULL,
			`option_lang` varchar(2) NOT NULL,
			 PRIMARY KEY (`id`)
		) 
		ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
		";
		$this->db->query($query);
		
		
		
		
		//inserting 
		$query = "
			
		INSERT INTO `emails_options` (`id`, `option_name`, `option_value`, `option_text`, `option_lang`) VALUES
			(1, 'send_email_on_receive', 1, 'Your order has been recieved', 'en'),
			(2, 'send_email_on_done', 1, 'Your order is done', 'en'),
			(3, 'send_email_on_deliver', 1, 'your order has been delivered', 'en'),
			(4, 'send_email_on_receive', 1, 'تم استلام طلبك', 'ar'),
			(5, 'send_email_on_done', 1, 'اصبح طلبكم جاهز', 'ar'),
			(6, 'send_email_on_deliver', 1, 'لقد تم تسليم طبلكم', 'ar'),
			(7, 'send_email_on_cancelled', 1, 'you order has been cancelled', 'en'),
			(8, 'send_email_on_cancelled', 1, 'تم الاعتذار عن طلبكم', 'ar')
		";
		$this->db->query($query);
		
		$query = "
			
		INSERT INTO `additions` (`id`, `name`) VALUES
			(1, 'examine_date'),
			(2, 'examining_cost'),
			(3, 'delivery_date'),
			(4, 'cost_estimation'),
			(5, 'order_number'),
			(6, 'repair_cost'),
			(7, 'spare_parts_cost'),
			(8, 'total_cost'),
			(14, 'recieve_date'),
			(18, 'deliver_date')
		";
		$this->db->query($query);
		
		$query = "
			
		INSERT INTO `options` (`id`, `option_name`, `option_value`, `option_text`, `option_lang`) VALUES
			(1, 'send_sms_on_receive', '1', 'Your order has been recived.', 'en'),
			(2, 'send_sms_on_done', '1', 'Your order is ready you can come to deliver it.', 'en'),
			(3, 'send_sms_on_deliver', '1', 'Your  order has been delivered.', 'en'),
			(4, 'send_sms_on_receive', '1', 'لقد تم استلام طلبكم . شكرا لكم لتعاملكم معنا.', 'ar'),
			(5, 'send_sms_on_done', '1', 'أصبح طلبكم جاهزاً.', 'ar'),
			(6, 'send_sms_on_deliver', '1', 'تم تسليم طلبكم', 'ar'),
			(7, 'send_sms_on_cancelled', '1', 'Your order has been cancelled.', 'en'),
			(8, 'send_sms_on_cancelled', '1', 'لقد تم إلغاء طلبكم. شكرا .', 'ar')

		";
		$this->db->query($query);
		
		$query = "
			
		INSERT INTO `options_additions` (`id`, `add_id`, `option_name`, `value`) VALUES
			(1, 1, 'send_sms_on_receive', 1),
			(2, 2, 'send_sms_on_receive', 1),
			(3, 3, 'send_sms_on_receive', 1),
			(4, 4, 'send_sms_on_receive', 1),
			(5, 5, 'send_sms_on_receive', 1),
			(6, 14, 'send_sms_on_receive', 1),
			(7, 5, 'send_sms_on_done', 0),
			(8, 6, 'send_sms_on_done', 1),
			(9, 7, 'send_sms_on_done', 0),
			(10, 8, 'send_sms_on_done', 0),
			(11, 5, 'send_sms_on_deliver', 0),
			(12, 6, 'send_sms_on_deliver', 0),
			(13, 7, 'send_sms_on_deliver', 0),
			(14, 8, 'send_sms_on_deliver', 0),
			(15, 18, 'send_sms_on_deliver', 0),
			(16, 5, 'send_sms_on_cancelled', 1),
			(17, 2, 'send_sms_on_cancelled', 0)

		";
		$this->db->query($query);
		
		$query = "
			
	
		INSERT INTO `options_additions_emails` (`id`, `add_id`, `option_name`, `value`) VALUES
			(1, 1, 'send_email_on_receive', 1),
			(2, 2, 'send_email_on_receive', 1),
			(3, 3, 'send_email_on_receive', 1),
			(4, 4, 'send_email_on_receive', 1),
			(5, 5, 'send_email_on_receive', 1),
			(6, 14, 'send_email_on_receive', 1),
			(7, 5, 'send_email_on_done', 1),
			(8, 6, 'send_email_on_done', 1),
			(9, 7, 'send_email_on_done', 1),
			(10, 8, 'send_email_on_done', 1),
			(11, 5, 'send_email_on_deliver', 1),
			(12, 6, 'send_email_on_deliver', 1),
			(13, 7, 'send_email_on_deliver', 1),
			(14, 8, 'send_email_on_deliver', 1),
			(15, 18, 'send_email_on_deliver', 1),
			(16, 5, 'send_email_on_cancelled', 1),
			(17, 2, 'send_email_on_cancelled', 1)

		";
		$this->db->query($query);*/
		
		$query ="
		INSERT INTO `actions_categories` (`id`, `name`) VALUES
			(8, 'Edited'),
			(9, 'Examinig'),
			(10, 'Send message')
		";
		$this->db->query($query);
		
		
		
		
		redirect('main');
	}
	
	
	
}