(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[41],{156:function(e,t,c){"use strict";c.r(t),c.d(t,"Block",(function(){return d}));var a=c(0),n=c(1),r=c(4),s=c.n(r),l=c(29),o=c(24),u=c(86),b=c(48);c(276);const d=e=>{const{className:t,align:c}=e,r=Object(u.a)(e),{parentClassName:b}=Object(o.useInnerBlockLayoutContext)(),{product:d}=Object(o.useProductDataContext)();if(!d.id||!d.on_sale)return null;const p="string"==typeof c?`wc-block-components-product-sale-badge--align-${c}`:"";return Object(a.createElement)("div",{className:s()("wc-block-components-product-sale-badge",t,p,{[`${b}__product-onsale`]:b},r.className),style:r.style},Object(a.createElement)(l.a,{label:Object(n.__)("Sale","woocommerce"),screenReaderLabel:Object(n.__)("Product on sale","woocommerce")}))};t.default=Object(b.withProductDataContext)(d)},276:function(e,t){},29:function(e,t,c){"use strict";var a=c(0),n=c(4),r=c.n(n);t.a=({label:e,screenReaderLabel:t,wrapperElement:c,wrapperProps:n={}})=>{let s;const l=null!=e,o=null!=t;return!l&&o?(s=c||"span",n={...n,className:r()(n.className,"screen-reader-text")},Object(a.createElement)(s,{...n},t)):(s=c||a.Fragment,l&&o&&e!==t?Object(a.createElement)(s,{...n},Object(a.createElement)("span",{"aria-hidden":"true"},e),Object(a.createElement)("span",{className:"screen-reader-text"},t)):Object(a.createElement)(s,{...n},e))}}}]);