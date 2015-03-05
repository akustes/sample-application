		
		
			<div class="page-header">
				<h1><a href="<?= site_url('control/events')?>"></a> <?= lang('dashboard')?> </h1>
			</div>
			
			<div class="row">&nbsp;</div>
			
			<div class="row">
					
				<div class="col-sm-6 col-md-6 col-lg-6">
				
					<div class="slate">
					
						<div class="page-header">
							<h2><i class="glyphicon glyphicon-calendar pull-right"></i><?= lang('upcoming_events')?></h2>
						</div>
						<? if(permission_check('events', 'view')):?>
						<table class="orders-table table">
						<tbody>
						<? if($events):?>
						
							<? foreach($events as $event):?>
							
							<?
								switch($event['event_invite_status'])
								{
									case 'attending':
										$label_class = 'label-success';
									break;
									case 'invited':
										$label_class = 'label-warning';
									break;
									case 'invite':
										$label_class = 'label-primary';
									break;
									case 'not_attending':
										$label_class = 'label-default';
									break;
									case 'cancelled':
										$label_class = 'label-danger';
									break;
									default:
										$label_class = 'label-default';
								}
								
							?>
							
							<tr>
								<td><a href="<?= site_url('events/view/' . $event['event_id'])?>"><?= unix_to_human($event['event_start_date'], TRUE, 'us')?> - <?= $event['event_name']?></a></td>
								<td><span class="label <?= $label_class?>"><?= ucfirst($event['event_invite_status'])?></span></td>
							</tr>
							<? endforeach?>
							<tr>
								<td colspan="2"><a href="<?= site_url('events')?>" class="btn btn-custom">View More Events</a></td>
							</tr>
						<? else:?>
							<tr>
								<td colspan="2"><?= lang('events_no_results')?></td>
							</tr>
						<? endif?>
						</tbody>
						</table>
						<? endif?>
					</div>
				
				</div>
				
				<div class="col-sm-6 col-md-6 col-lg-6">
				
					<div class="slate">
					
						<div class="page-header">
							<h2><i class="glyphicon glyphicon-stats pull-right"></i></h2>
						</div>
						<div id="placeholder" style="height: 297px;"></div>
					
					</div>
				
				</div>

			
			</div>