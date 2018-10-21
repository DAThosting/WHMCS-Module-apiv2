{foreach $hookOutput as $output}
<div>
   {$output}
</div>
{/foreach}
{if $systemStatus == 'Active'}
<style>
   .modal {
   }
   .vertical-alignment-helper {
   display:table;
   height: 100%;
   width: 100%;
   }
   .vertical-align-center {
   /* To center vertically */
   display: table-cell;
   vertical-align: middle;
   }
   .modal-content {
   /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
   width:inherit;
   height:inherit;
   /* To center horizontally */
   margin: 0 auto;
   }
</style>
<div class="panel panel-default" id="cPanelConfigurableOptionsPanel">
   <div class="panel-heading">
      <h3 class="panel-title">{$LANG.orderlogininfo}</h3>
   </div>
   <div class="panel-body">
      <div class="row">
         <div class="col-md-5 col-xs-6 text-right">
            <strong>{$LANG.serverusername}</strong>
         </div>
         <div class="col-md-7 col-xs-6 text-left">
            {$username}
         </div>
      </div>
	  <div class="row">
         <div class="col-md-5 col-xs-6 text-right">
            <strong>{$LANG.domainregisternsip}</strong>
         </div>
         <div class="col-md-7 col-xs-6 text-left">
			{$dedicatedip|regex_replace:'/:.*/':''}
         </div>
      </div>
	  <div class="row">
         <div class="col-md-5 col-xs-6 text-right">
            <strong>Port</strong>
         </div>
         <div class="col-md-7 col-xs-6 text-left">
			{$dedicatedip|replace:($dedicatedip|regex_replace:'/:.*/':''):''|replace:':':''}
         </div>
      </div>
	  <div class="row">
         <div class="col-md-5 col-xs-6 text-right">
            <strong>{$LANG.orderserverhostname}</strong>
         </div>
         <div class="col-md-7 col-xs-6 text-left">
			<b>{$dedicatedip}</b>
         </div>
      </div>
      <div class="row">
         <div class="col-md-5 col-xs-6 text-right">
            <strong>ServerID</strong>
         </div>
         <div class="col-md-7 col-xs-6 text-left">
            {$customfields.ID}
         </div>
      </div>
      <br>
      <a href="http://{$serverhostname}" target="_blank" class="btn btn-block btn-success">{$LANG.virtualminlogin}</a>
   </div>
</div>

{else}

<div class="alert alert-warning text-center" role="alert" id="cPanelSuspendReasonPanel">
   {if $suspendreason}
   <strong>{$suspendreason}</strong><br />
   {/if}
   {$LANG.cPanel.packageNotActive} {$status}.<br />
   {if $systemStatus eq "Pending"}
   {$LANG.cPanel.statusPendingNotice}
   {elseif $systemStatus eq "Suspended"}
   {$LANG.cPanel.statusSuspendedNotice}
   {/if}
</div>
{/if}
