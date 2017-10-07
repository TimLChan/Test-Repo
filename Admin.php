<script type="text/javascript" src="/scripts/CalendarPopup.js"></script>
    <script type="text/javascript">
        <!--
        onload = window_load;
        var cal = new CalendarPopup( "caldiv" );
        cal.showNavigationDropdowns();
        -->
    </script>
<?php
//die( $aPages[ 2 ] );
if ( ! is_numeric( $aPages[ 2 ] ) )
{
    echo 'Invalid server id!';
}
else
{
    $sTitle .= ' - Editing Server';
    $aInfo = $MySQL -> SelectOne( 'user_server_lists', '`id` = ' . $aPages[ 2 ] );
    $aLogin = $MySQL -> SelectOne( 'user_logins', '`id` = ' . $aPages[ 2 ] );
    $aServer = $MySQL -> SelectEx( 'server_lists' );
    $aHServer = $Config[ 'servers:' ];
    $iAServerId = 0;

$oRes = $MySQL -> selectOne( 'order_comments', '`server` = ' . $aInfo[ 'id' ] );
if ( $oRes !== false )
{
    echo '<h3>Order Comments</h3>' . stripslashes( $oRes[ 'comment' ] ) . '<br /><br />';
}


?>
<a href="/cp/serv/<?php echo $aInfo[ 'id' ]; ?>/">Back to Server</a>
<h2><img src="images/star_title.png" alt="*" /> Server Settings</h2>
<form id="svr_edit" name="svr_edit" method="post" action="/actions/server_actions.php?edit=<?php echo $aInfo[ 'id' ]; ?>">
    <table width="450" border="0">
      <tr>
        <td width="115">ID</td>
        <td width="325"><?php echo $aInfo[ 'id' ]; ?></td>
      </tr>
      <tr>
        <td>Type</td>
        <td>
            <?php
            foreach( $aServer as $iId => $aItem )
            {
                if ( $aItem[ 'id' ] == $aInfo[ 'type' ] )
                {
                    echo $aItem[ 'id' ];
                    $iAServerId = $iId;
                }
            }
            ?>
        </td>
      </tr>
      <tr>
        <td>Slots</td>
        <td>
            <select name="slots" id="slots">
                <?php
                for ( $x = $aServer[ $iAServerId][ 'min_slots' ]; $x <= $aServer[ $iAServerId][ 'max_slots' ]; $x++ )
                {
                    if ( $x == $aInfo[ 'slots' ] )
                        echo '<option value="' . $x . '" selected>' . $x . '</option>';
                    else
                        echo '<option value="' . $x . '">' . $x . '</option>';
                }
                ?>

            </select>
        </td>
      </tr>
      <tr>
        <td>Owner</td>
        <td>
            <input type="text" name="owner" id="owner" value="<?php echo $Users[ $aInfo[ 'owner'] ][ 'name']; ?>" />
        </td>
      </tr>
      <tr>
        <td>Server Ip:Port</td>
        <td>
        <?php
        list( $sIp, $iPort ) = explode( ':', $aInfo[ 'server_ip_port' ] );
        ?>
            <input name="svr" type="text" id="svr" value="<?php echo $sIp; ?>" />
          :
          <input name="port" type="text" id="port" size="8" maxlength="6" value="<?php echo $iPort; ?>" />
        </td>
      </tr>
      <tr>
        <td>Server ID</td>
        <td>
            <select name="server_id" id="type_id3">
            <?php
            foreach( $aHServer as $iId => $aServ )
            {
                if ( $aInfo[ 'server_id' ] != $iId )
                    echo '<option value="' . $iId . '">' . $aServ[ 'ip' ] . '</option>';
                else
                    echo '<option value="' . $iId . '" selected >' . $aServ[ 'ip' ] . '</option>';
            }

            ?>
            </select>
        </td>
      </tr>
      <tr>
        <td>Process ID</td>
        <td><input type="text" name="pid" id="pid" value="<?php echo $aInfo[ 'pid' ]; ?>" /></td>
      </tr>
      <tr>
        <td>Status</td>
        <td>
            <?php
            $bActive = false;
            if ( $aInfo[ 'active' ] == 1 )
            {
                $sActYes = 'checked="checked"';
                $sActNo = '';
                $sActPay = '';
            }
            else if ( $aInfo[ 'active' ] == -1 )
            {
                $sActYes = '';
                $sActNo = '';
                $sActPay = 'checked="checked"';
            }
            else
            {
                $sActYes = '';
                $sActNo = 'checked="checked"';
                $sActPay = '';
            }
            ?>
            <input type="radio" name="active" id="active_y" value="1" <?php echo $sActYes; ?> />
            Active
            <input name="active" type="radio" id="active_n" value="0" <?php echo $sActNo; ?> />
            Inactive
            <input name="active" type="radio" id="active_d" value="-1" <?php echo $sActPay ; ?> />
            Unpaid
        </td>
      </tr>
      <tr>
        <td>Created</td>
        <td><input type="text" name="created" id="created" value="<?php $aI=explode(' ',$aInfo['created']); echo $aI[0]; ?>"	 />
            <a href="#" onclick="cal.select(document.getElementById( 'created' ),'lpaid3_a','yyyy-MM-dd'); positionFooter( ); return false;" name="lpaid3_a" id="lpaid3_a">Select</a>
            00:00:00</td>
      </tr>
      <tr>
        <td>Terms</td>
        <td>+
        <input name="terms" type="text" id="terms" size="6" maxlength="6" value="<?php echo trim( str_replace( array( '+','Months'), '', $aInfo[ 'term' ] ) ); ?>" />
        Months</td>
      </tr>
      <tr>
        <td>Last Paid</td>
        <td><input type="text" name="last_paid" id="last_paid" value="<?php $aI=explode(' ',$aInfo[ 'last_paid' ]); echo $aI[0]; ?>" />
        <a href="#" onclick="cal.select(document.getElementById( 'last_paid' ),'lpaid_a','yyyy-MM-dd'); positionFooter( ); return false;" name="lpaid_a" id="lpaid_a">Select</a>
        00:00:00</td>
      </tr>
      <tr>
        <td>Last Renewed</td>
        <td><input type="text" name="last_renewed" id="last_renewed" value="<?php $aI=explode(' ',$aInfo[ 'last_renewed' ]); echo $aI[0]; ?>" />
        <a href="#" onclick="cal.select(document.getElementById( 'last_renewed' ),'lpaid2_a','yyyy-MM-dd'); positionFooter( ); return false;" name="lpaid2_a" id="lpaid2_a">Select</a>
        00:00:00</td>
      </tr>
      <tr>
        <td>Remote Username</td>
        <td><input type="text" name="rusr" id="rusr" value="<?php echo $aLogin[ 'username' ]; ?>" /></td>
      </tr>
      <tr>
        <td>Remote Password</td>
        <td><input type="text" name="rpsw" id="rpsw" value="<?php echo $aLogin[ 'password' ]; ?>" /></td>
      </tr>
    </table>

    <input type="submit" name="submit" value="Edit Configurations" />
</form>
<?php
$oRes = $MySQL -> selectOne( 'order_comments', '`server` = ' . $iId );
if ( $oRes )
{
    echo '<h3>Order Comments</h3>' . stripslashes( $oRes[ 'comment' ] );
}
?>
<div id="caldiv" style=""></div>
<?php
}
?>
