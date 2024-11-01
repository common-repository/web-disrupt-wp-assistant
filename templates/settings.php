<?php
/**
 * Wdwa template: Settings
 *
 * This template is for the main admin area settings and controls
 *
 * @since  1.0.0
 * @package  WebDisrupt WordPress Assistant
 * 
 */

?>

<style>
    .notice-error, div.error {
        display: none;
    }
</style>
<div class="wdwa-header">
    <div class="branding">
        <img src="<?php echo $logo; ?>" />
        <img src="<?php echo $typography; ?>" />
        v<?php echo $version; ?> </h1>
    </div>
    <div class="wdwa-sub-header">
    <a href="https://webdisrupt.com/"> Get <b>FREE</b> extended training on this system. Click Here! </a>
    </div>
</div>

<div id="getting-started-page" class="wdwa-body">

<div id="main-wdwa-body-container">
    <div id="super-easy-getting-started-area">
        <div class="row">
            <div class="desc">
            <h1>Blast Off! <small style="color:#666">One-click Setup</small></h1>
            Let us build out your WordPress site for you. We will install the following. The core being something every site should have installed. We have created a custom minimalistic theme <b> Disrupt One </b>. You should be using Elementor for everything adn not relying on theme customizations at all.
            <h2>Web Disrupt Core</h2>
            <ul>
                <li> <b> Theme: Disrupt One </b>- Most minimal theme possible. Less is More. </li>
                <li> <b> Plugin: Elementor </b>- Best realtime visual page/theme build available. </li>
                <li> <b> Plugin: Funnelmentals </b>- Essential Elementor addon to extend functionality. </li>
                <li> <b> Plugin: Elementor Library Unlimited </b>- More premium templates for Elementor. </li>
            </ul>
            <h2>Optional <small style="color:#009900">*Trusted</small></h2>
            <ul>
            <?php
            foreach ($wdwa_optional_plugins as $e) {
                echo '<li> <input'
                . ' data-name=' . $e['title']
                . ' data-link-install = "'. site_url('/wp-admin/update.php?action=install-plugin&plugin='.$e['wp-name'].'&_wpnonce='.wp_create_nonce("install-plugin_".$e['wp-name'])).'" '
                . ' data-link-activate = "'. site_url('/wp-admin/plugins.php?action=activate&plugin='.$e['plugin'].'&_wpnonce='.wp_create_nonce("activate-plugin_".$e['plugin'])).'" '
                .'class="get-checkbox" type="checkbox" data-title /> <b> Plugin: '.$e['title'].' </b>- '.$e['desc'].' </li>';
            } 
            ?>
            </ul>
            </div>
        </div>
        <div class="row">
            <div class='wdwa-task-name __hide'></div>
            <div class="wdwa-meter blue animate __hide">
                <span style="width: 0%"><span></span></span>
            </div>
            <div class="__center">
                <div id="install-wd-core-setup"> Install & Configure </div>
            </div>
            <div id="load-built-in-wp-links" style="position:fixed;left:-9999px;"></div><!-- Iframe Location -->
        </div>
    </div>
    <div class="main-sidebar">
       <div class="title"><span>Recommended</span></div>
        <?php 
            foreach ($premium_sidebar as $e) {
                echo '<a href="'.$e['link'].'" > <img src="'.$images_path.$e['image'].'" /> '.$e['title'].' </a>';
            }
        ?>
    </div>
</div>

</div> <!-- wdwa-body Getting Started -->

<script>
<?php
    echo 'iList=[];';
    echo 'iList[0] = {'.
        ' name : "Disrupt One", '.
        ' type : "theme" '.
        ' };';
    for ($i=0; $i < count($wdwa_plugins); $i++) { 
        $t_count = $i+1;
        echo 'iList['.$t_count.'] = {'.
        ' name : "'.$wdwa_plugins[$i]['title'].'", '.
        ' type : "plugin", '.
        ' linkInstall : "'. site_url('/wp-admin/update.php?action=install-plugin&plugin='.$wdwa_plugins[$i]['wp-name'].'&_wpnonce='.wp_create_nonce("install-plugin_".$wdwa_plugins[$i]['wp-name'])).'", '. 
        ' linkActivate : "'. site_url('/wp-admin/plugins.php?action=activate&plugin='.$wdwa_plugins[$i]['plugin'].'&_wpnonce='.wp_create_nonce("activate-plugin_".$wdwa_plugins[$i]['plugin'])).'" '.
        ' };';
    }
?>  

/* Fire Ajax Events */
jQuery( document ).ready(function($) {

    setTimeout(() => {
        console.log(iList);
    }, 200);


    /* Runs through and fires all tasks one, after, another */
    var runTasks = function(tasks, i, iMax){ 
        
        /* Set Progress */
        var progressStep = (100/iMax);
        var progress1 = (i+.5) * progressStep;
        var progress2 = (i+1) * progressStep;

        if(i == iMax){ taskRunnerComplete(); return; }
            if(tasks[i].type == "plugin"){
                //Install Plugin
                var iFrameObj = document.createElement('IFRAME');
                $(iFrameObj).css("display", "none");
                iFrameObj.src = tasks[i].linkInstall;
                $('#load-built-in-wp-links').html(iFrameObj);
                $(".wdwa-task-name").html(tasks[i].name + " Installling");
                $(iFrameObj).load( function () {
                    // Activate plugin
                    $(".wdwa-task-name").html(tasks[i].name + " Activating");
                    var iFrameObj = document.createElement('IFRAME');
                    $(iFrameObj).css("display", "none");
                    $(".wdwa-meter span").css("width", progress1+"%");
                    iFrameObj.src = tasks[i].linkActivate;
                    $('#load-built-in-wp-links').html(iFrameObj);
                    $(iFrameObj).load( function () {
                       $(".wdwa-meter span").css("width", progress2+"%");
                       runTasks(tasks, i+1, iMax); 
                    });
                });
            } 
            else if (tasks[i].type == "theme"){
                // Install New theme
                $(".wdwa-task-name").html("Downloading "+tasks[i].name);
                $.post(ajaxurl, { action : 'wdwa_generate_theme', data: { id : "none" }}, function(data) {
                    setTimeout(function(){

                        var iFrameObj = document.createElement('IFRAME');
                        $(iFrameObj).css("display", "none");
                        iFrameObj.src = data;
                        $('#load-built-in-wp-links').html(iFrameObj);
                        $(".wdwa-meter span").css("width", progress1+"%");
                        $(iFrameObj).load( function () {
                            $(".wdwa-task-name").html("Switching Theme to "+tasks[i].name);
                            $(".wdwa-meter span").css("width", progress2+"%");
                            runTasks(tasks, i+1, iMax);
                        });
                        
                    }, 1000);
                });
            }
    } 


    /* If task succeed */
    var taskRunnerComplete = function(){
        $(".wdwa-meter, .wdwa-task-name").addClass("__hide");
        $(".wdwa-meter span").css("width", "0%");
        console.log("done");
    }


    /* Handle click for perfect setup */
    $('#install-wd-core-setup').click(function(){ 

        /* Get Optional Plugin Installs */
        $('.get-checkbox').each(function(){
            if($(this).is(':checked')){
                iList[iList.length] =
                { 
                  name : $(this).attr('data-name'),
                  type : "plugin",
                  linkInstall : $(this).attr('data-link-install'),
                  linkActivate: $(this).attr('data-link-activate')
                };
            }
        });
        $(".wdwa-meter, .wdwa-task-name").removeClass("__hide");
        runTasks(iList, 0, iList.length);       
    });


});

</script>