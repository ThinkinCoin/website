(()=>{"use strict";document.addEventListener("DOMContentLoaded",(()=>{!function(e){const{activating:t,installing:s,done:a,activationUrl:o,ajaxUrl:c,nonce:n,otterRefNonce:i,otterStatus:r}=raftData,d=e(".raft-welcome-notice #raft-install-otter"),l=e(".raft-welcome-notice .notice-dismiss"),u=e(".raft-welcome-notice"),f=d.find(".text"),m=d.find(".dashicons"),w=()=>{u.fadeTo(100,0,(()=>{u.slideUp(100,(()=>{u.remove()}))}))},p=async()=>{var s;f.text(t),await(s=o,new Promise((e=>{jQuery.get(s).done((()=>{e({success:!0})})).fail((()=>{e({success:!1})}))}))),await e.post(c,{nonce:i,action:"raft_set_otter_ref"}),m.removeClass("dashicons-update"),m.addClass("dashicons-yes"),f.text(a),setTimeout(w,1500)};e(d).on("click",(async()=>{m.removeClass("hidden"),d.attr("disabled",!0),"installed"!==r?(f.text(s),await new Promise((e=>{wp.updates.ajax("install-plugin",{slug:"otter-blocks",success:()=>{e({success:!0})},error:t=>{e({success:!1,code:t.errorCode})}})})),await p()):await p()})),e(l).on("click",(()=>{e.post(c,{nonce:n,action:"raft_dismiss_welcome_notice",success:w})}))}(jQuery)}))})();