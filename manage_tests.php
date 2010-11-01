<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table style="border:1px solid #e5e5e5;" cellpadding="9" class="usrlst">
	<tr>
    	<td>
        	<input type="button" class="button gray medium2" value="Add Domain1" onClick="ajax_call('show_addDomain')"/>
        </td>
        <td>
        	<input type="button" class="button orange medium2" value="Add Test" onClick="addTest('*null*','*null*')"/>
        </td>
        <td>
        	<input type="button" class="button white medium2" value="Add Question Directly" onClick="addQuesDirectly()"/>
        </td>
        <td>
        	<input type="button" class="button green medium2" value="Modify Existing Tests" onClick="ajax_call('show_modify')"/>

        </td>
        <td>
        	<input type="button" class="button blue medium2" value="Show Existing Tests" onClick="ajax_call('show_delete')"/>
        </td>
    </tr>
</table>

<div id="contentval"><!-- this is the full content div to be updated on ajax call of the entire right container-->
    <div id="hide_list">
    	<h4><strong>Click on a Category.</strong></h4>
   
    			<ul>
                    <div id="listTestDomain"></div>
                </ul>
	</div><!-- this is to hide the list when needed-->
        			<div id="change"><!-- this is the div to be updated on ajax call of the  right container-->
                    </div><!-- this is end of change div-->
                        
</div><!-- this is end of content div-->
                    