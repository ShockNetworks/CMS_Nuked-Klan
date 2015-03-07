<?php
/**
 * @version     1.7.10
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2015 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $language, $user, $nuked;

translate('modules/Admin/lang/' . $language . '.lang.php');
include('modules/Admin/design.php');

$visiteur = $user ? $user[1] : 0;

if ($visiteur >= 2)
{
    admintop();
    ?>
    <!-- Page Head -->
    <h2><?php echo _BONJOUR . '&nbsp;' . $user[2]; ?></h2>
    <p id="page-intro"><?php echo _MESSAGEDEBIENVENUE; ?></p>
        <div style="text-align: right">
        <form method="post" onsubmit="maFonctionAjax3(this.module.value);return false" action="">
            <fieldset>
            <select id="module" name="module">
                <option value="Admin"><?php echo _PANNEAU; ?></option>
                <?php
                $modules = array();
                $sql = mysql_query('SELECT nom FROM ' . MODULES_TABLE . ' WHERE "' . $visiteur . '" >= admin AND niveau > -1 AND admin > -1 ORDER BY nom');
                while (list($mod) = mysql_fetch_array($sql))
                {
                    if ($mod == 'Gallery') $modname = _NAMEGALLERY;
                    else if ($mod == 'Calendar') $modname = _NAMECALANDAR;
                    else if ($mod == 'Defy') $modname = _NAMEDEFY;
                    else if ($mod == 'Download') $modname = _NAMEDOWNLOAD;
                    else if ($mod == 'Guestbook') $modname = _NAMEGUESTBOOK;
                    else if ($mod == 'Irc') $modname = _NAMEIRC;
                    else if ($mod == 'Links') $modname = _NAMELINKS;
                    else if ($mod == 'Wars') $modname = _NAMEMATCHES;
                    else if ($mod == 'News') $modname = _NAMENEWS;
                    else if ($mod == 'Recruit') $modname = _NAMERECRUIT;
                    else if ($mod == 'Sections') $modname = _NAMESECTIONS;
                    else if ($mod == 'Server') $modname = _NAMESERVER;
                    else if ($mod == 'Suggest') $modname = _NAMESUGGEST;
                    else if ($mod == 'Survey') $modname = _NAMESURVEY;
                    else if ($mod == 'Forum') $modname = _NAMEFORUM;
                    else if ($mod == 'Textbox') $modname = _NAMESHOUTBOX;
                    else if ($mod == 'Comment') $modname = _NAMECOMMENT;
                    else $modname = $mod;

                    array_push($modules, $modname . '|' . $mod);
                }

                natcasesort($modules);
                foreach($modules as $value)
                {
                    $temp = explode('|', $value);

                    if (is_file('modules/' . $temp[1] . '/admin.php') AND is_file('modules/' . $temp[1] . '/menu/'.$language.'/menu.php'))
                    {
                        echo '<option value="' . $temp[1] . '">' . $temp[0] . '</option>';
                    }
                }
                ?>
            </select>
            <input class="button" type="submit" value="Send" />
            </fieldset>
        </form>
        </div>
        <ul class="shortcut-buttons-set" id="1">
            <li>
                <a class="shortcut-button" href="modules/Admin/menu/<?php echo $language; ?>/aide.php" rel="modal">
                    <img src="modules/Admin/images/icons/aide.png" alt="icon" />
                    <span><?php echo _AIDE; ?></span>
                </a>
            </li>

            <li>
                <a class="shortcut-button" rel="modal" href="index.php?file=Stats&amp;nuked_nude=admin">
                    <img src="modules/Admin/images/icons/statistiques.png" alt="icon" />
                    <span><?php echo _STATS; ?></span>
                </a>
            </li>

            <li>
                <a class="shortcut-button" href="index.php?file=Admin&amp;page=erreursql">
                    <img src="modules/Admin/images/icons/erreur.png" alt="icon" />
                    <span><?php if($language=='english'){echo '<br/>';} echo _SQL; ?></span>
                </a>
            </li>

            <li>
                <a class="shortcut-button" href="#notification" rel="modal">
                    <img src="modules/Admin/images/icons/megaphone.png" alt="icon" />
                    <span><?php echo _NOTIFICATION; ?></span>
                </a>
            </li>

            <li>
                <a class="shortcut-button" href="#messages" rel="modal">
                    <img src="modules/Admin/images/icons/comment_48.png" alt="icon" />
                    <span><?php echo _DISCUSSION; ?></span>
                </a>
            </li>
            <?php
                if(file_exists('themes/' . $nuked['theme'] . '/admin.php'))
                {
                    if (file_exists('themes/' . $nuked['theme'] . '/images/adminpanel.png'))
                        $imagepanel = 'themes/' . $nuked['theme'] . '/images/adminpanel.png';
                    else $imagepanel = 'modules/Admin/images/icons/logo.png';
                ?>
                <li>
                    <a class="shortcut-button" href="index.php?file=Admin&amp;page=theme">
                        <img src="<?php echo $imagepanel; ?>" alt="icon" />
                        <span><?php echo _THEMEPANEL; ?></span>
                    </a>
                </li>
            <?php
                }
            ?>
        </ul><!-- End .shortcut-buttons-set -->

        <div class="clear"></div><!-- End .clear -->
            <div id="notification" style="display: none">
                <h3><?php echo _NOTIFICATION; ?>:</h3>
                <form method="post" onsubmit="maFonctionAjax2(this.texte.value,this.type.value);return false" action="">
                    <h4><?php echo _MESSAGE; ?>:</h4>
                    <fieldset>
                        <textarea name="texte" cols="79" rows="5"></textarea>
                    </fieldset>

                    <fieldset>
                        <select id="type" name="type" class="small-input">
                            <option value="0"><?php echo _TYPE; ?>...</option>
                            <option value="1"><?php echo _INFO; ?></option>
                            <option value="2"><?php echo _ECHEC; ?></option>
                            <option value="3"><?php echo _REUSSITE; ?></option>
                            <option value="4"><?php echo _ALERTE; ?></option>
                        </select>

                        <input class="button" type="submit" value="Send" />
                    </fieldset>
                </form>
            </div>

            <div style="width: 100%">
                <div class="content-box column-left">
                    <div class="content-box-header" style="margin-bottom: 0">
                        <h3><?php echo _ANNONCES; ?></h3>
                    </div><!-- End .content-box-header -->

                    <div class="content-box-content">
                        <div class="tab-content default-tab" id="NKmess">
                            <p>
                                <?php echo _CONNECTNK; ?>
                            </p>
                        </div><!-- End #tab3 -->
                        <div class="tab-content default-tab" id="NKUpdate">
                            <!-- NK.UPDATE CONTENT -->
                        </div><!-- End #tab3 -->
                        <?php echo '<script type="text/javascript" src="http://www.nuked-klan.org/extra/message.php?version=' . $nuked['version'] . '&lang=' . $language . '"></script>'; ?>
                    </div><!-- End .content-box-content -->
                </div><!-- End .content-box -->

            <div class="content-box column-right">
                <div class="content-box-header" style="margin-bottom: 0"><!-- Add the class "closed" to the Content box header to have it closed by default -->
                    <h3><?php echo _ACTIONS; ?></h3>
                </div><!-- End .content-box-header -->

                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <h4><a href="index.php?file=Admin&amp;page=action"><?php echo _VIEWACTIONS; ?></a></h4>
                        <p>
                        <?php
                        $sql_act = mysql_query("SELECT date, pseudo, action  FROM " . $nuked['prefix'] . "_action ORDER BY date DESC LIMIT 0, 3");
                        while ($action = mysql_fetch_array($sql_act))
                        {
                            $sql = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $action['pseudo'] . "'");
                            list($pseudo) = mysql_fetch_array($sql);

                            $action['action'] = $pseudo . ' ' . $action['action'];
							$action['date'] = nkDate($action['date']);

                            echo '<div style="font-size: 12px"><em>' . $action['date'] . '</em></div>
                            <div style="font-size: 12px; margin-bottom: 4px">' . $action['action'] . '</div>';
                        }
                        ?>
                        </p>
                    </div><!-- End #tab3 -->
                </div><!-- End .content-box-content -->
            </div><!-- End .content-box -->
            <div class="clear"></div>
        </div>

        <!-- Start Notifications -->
        <?php
            $sql2 = mysql_query('SELECT id, type, texte  FROM ' . $nuked['prefix'] . '_notification ORDER BY date DESC LIMIT 0, 4');
            while (list($id, $type, $texte) = mysql_fetch_array($sql2))
            {
                if($type == 4)
                {
                ?>

                <div class="notification attention png_bg">
                    <?php if ($visiteur == 9) ?>
                    <a onclick="del('<?php echo $id; ?>');return false" href="#"  class="close"><img src="modules/Admin/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                    <div>
                        <?php echo _ALERTENOT; ?>. <?php echo $texte; ?>
                    </div>
                </div>
                <?php
                }
                else if($type == 1)
                {
                ?>
                <div class="notification information png_bg">
                    <?php if ($visiteur == 9) ?>
                    <a onclick="del('<?php echo $id; ?>');return false" href="#" class="close"><img src="modules/Admin/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                    <div>
                        <?php echo _INFONOT; ?>. <?php echo $texte; ?>
                    </div>
                </div>
                <?php
                }
                else if($type == 3)
                {
                ?>
                <div class="notification success png_bg">
                    <?php if ($visiteur == 9) ?>
                    <a onclick="del('<?php echo $id; ?>');return false" href="#" class="close"><img src="modules/Admin/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                    <div>
                        <?php echo _REUSSITENOT; ?>. <?php echo $texte; ?>
                    </div>
                </div>
                <?php
                }
                else if($type == 2)
                {
                ?>
                <div class="notification error png_bg">
                    <?php if ($visiteur == 9) ?>
                    <a onclick="del('<?php echo $id; ?>');return false" href="#" class="close"><img src="modules/Admin/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                    <div>
                        <?php echo _ECHOUENOT; ?>. <?php echo $texte; ?>
                    </div>
                </div>
                <?php
                }
            }
    adminfoot();
}
else
{
    admintop();
    echo '<div class="notification error png_bg">
        <div>
        <br /><br /><div style="text-align: center">' . _ZONEADMIN . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />
        </div>
    </div>';
    adminfoot();
}
?>
