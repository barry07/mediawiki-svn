<?php

$footerHtml = <<<EOD
    <div id='footer'> 
      <div class='nav' id='footmenu'> 
        <div class='mwm-notice'> 
          <a href="?m_action=view_normal_site">{$regularWikipedia}</a> 
            <div id="perm"> 
              <a href="?m_action=disable_mobile_site">{$permStopRedirect}</a> 
            </div> 
        </div> 
      </div> 
      <div id='copyright'>{$copyright}</div> 
    </div>

EOD;
