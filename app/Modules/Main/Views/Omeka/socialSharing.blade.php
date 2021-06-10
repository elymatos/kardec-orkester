<?php
if ($data->lang == 'fr') {
    $href = "https://projetokardec.ufjf.br/fr/item-fr/" . $data->id;
} else if ($data->lang == 'pt') {
    $href = "https://projetokardec.ufjf.br/item-pt/" . $data->id;
}
?>
<div class="sharedaddy sd-sharing-enabled">
    <div class="robots-nocontent sd-block sd-social sd-social-icon-text sd-sharing">
        <div class="sd-content">
            <ul data-sharing-events-added="true">
                <li><a rel="nofollow noopener noreferrer" data-shared="sharing-twitter-439"
                                             class="sd-button"
                                             href="{{$href}}?share=twitter&amp;nb=1"
                                             target="_blank" title="Click to share on Twitter"><i class="twitter icon"></i><span>Twitter</span></a>
                </li>
                <li><a rel="nofollow noopener noreferrer" data-shared="sharing-facebook-439"
                                              class="sd-button"
                                              href="{{$href}}?share=facebook&amp;nb=1"
                                              target="_blank"
                                              title="Click to share on Facebook"><i class="facebook icon"></i><span>Facebook</span></a></li>
                <li><a rel="nofollow noopener noreferrer" data-shared=""
                                              class="sd-button"
                                              href="{{$href}}?share=telegram&amp;nb=1"
                                              target="_blank"
                                              title="Click to share on Telegram"><i class="telegram icon"></i><span>Telegram</span></a></li>
                <li ><a rel="nofollow noopener noreferrer" data-shared=""
                                                      class="sd-button"
                                                      href="{{$href}}?share=jetpack-whatsapp&amp;nb=1"
                                                      target="_blank"
                                                      title="Click to share on WhatsApp"><i class="whatsapp icon"></i><span>WhatsApp</span></a></li>
                <li c><a rel="nofollow noopener noreferrer" data-shared="sharing-linkedin-439"
                                              class="sd-button"
                                              href="{{$href}}?share=linkedin&amp;nb=1"
                                              target="_blank"
                                              title="Click to share on LinkedIn"><i class="linkedin icon"></i><span>LinkedIn</span></a></li>
                <li></li>
            </ul>

    </div>
</div>