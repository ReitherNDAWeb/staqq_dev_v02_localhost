<?PHP 
if(!defined('ABSPATH')) { exit(); }
?>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body,html,table,tr,td,a,p,img {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
                line-height: 1.5;
                color: #373737;
            }
            .bton {
                padding: 8px 23px;
                background: #003473;
                display: inline-block;
                color: white;
                font-weight: normal;
                text-decoration: none; 
            }
        </style>
        <meta charset="utf-8" /> 
    </head>
    <body>	
        <table width="800" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.5">
            <tr>
                <td height="118" style="background-color: white;text-align:center" colspan="4" ><img style="margin:0 auto" src="https://via.placeholder.com/500x150" width="500" /></td>
            </tr>
            <tr>
                <td style="background-color: white; padding: 10px 35px 35px 35px; " colspan="4" >
                    <p>
                        <?= $data['msg'] ?? '' ?>
                    </p>
                </td>
            </tr>
            <tr style="width:100%" >               
                <td style="background-color: #4C4C4C; color: white; padding: 20px; width: 100%;">
                    <p style="color: white;  text-align: center;" >
                        Footer
                        <br />                         
                    </p>                  
                </td>                
            </tr>
        </table>
    </body>
</html>