"use strict";Object.defineProperty(exports,"__esModule",{value:!0}),exports.Edit=void 0;const block_templates_1=require("@woocommerce/block-templates"),data_1=require("@woocommerce/data"),core_data_1=require("@wordpress/core-data"),data_2=require("@wordpress/data"),element_1=require("@wordpress/element"),i18n_1=require("@wordpress/i18n"),shipping_dimensions_image_1=require("../../../components/shipping-dimensions-image"),validation_context_1=require("../../../contexts/validation-context"),number_control_1=require("../../../components/number-control"),SHIPPING_AND_WEIGHT_MIN_VALUE=0,SHIPPING_AND_WEIGHT_MAX_VALUE=1e14;function Edit({attributes:e,clientId:t,context:n}){var o,i,r;const l=(0,block_templates_1.useWooBlockProps)(e),[a,m]=(0,core_data_1.useEntityProp)("postType",n.postType,"dimensions"),[s,_]=(0,core_data_1.useEntityProp)("postType",n.postType,"weight"),[c]=(0,core_data_1.useEntityProp)("postType",n.postType,"virtual"),[d,u]=(0,element_1.useState)(),{dimensionUnit:h,weightUnit:p}=(0,data_2.useSelect)((e=>{const{getOption:t}=e(data_1.OPTIONS_STORE_NAME);return{dimensionUnit:t("woocommerce_dimension_unit"),weightUnit:t("woocommerce_weight_unit")}}),[]);function g(t,n){var o;return{name:`dimensions.${t}`,value:null!==(o=a&&a[t])&&void 0!==o?o:"",onChange:e=>m({...null!=a?a:{},[t]:e}),onFocus:()=>u(n),onBlur:()=>u(void 0),suffix:h,disabled:e.disabled||c,min:0,max:1e14}}const v=`dimensions_width-${t}`,{ref:w,error:b,validate:E}=(0,validation_context_1.useValidation)(v,(async function(){if((null==a?void 0:a.width)&&+a.width<=0)return{message:(0,i18n_1.__)("Width must be greater than zero.","woocommerce"),context:t}}),[null==a?void 0:a.width]),f=`dimensions_length-${t}`,{ref:x,error:N,validate:y}=(0,validation_context_1.useValidation)(f,(async function(){if((null==a?void 0:a.length)&&+a.length<=0)return{message:(0,i18n_1.__)("Length must be greater than zero.","woocommerce"),context:t}}),[null==a?void 0:a.length]),I=`dimensions_height-${t}`,{ref:S,error:P,validate:T}=(0,validation_context_1.useValidation)(I,(async function(){if((null==a?void 0:a.height)&&+a.height<=0)return{message:(0,i18n_1.__)("Height must be greater than zero.","woocommerce"),context:t}}),[null==a?void 0:a.height]),q=`weight-${t}`,{ref:A,error:B,validate:C}=(0,validation_context_1.useValidation)(q,(async function(){if(s&&+s<=0)return{message:(0,i18n_1.__)("Weight must be greater than zero.","woocommerce"),context:t}}),[s]),k={...g("width","A"),ref:w,onBlur:E,id:v},W={...g("length","B"),ref:x,onBlur:y,id:f},H={...g("height","C"),ref:S,onBlur:T,id:I},U={id:q,name:"weight",value:null!=s?s:"",onChange:_,suffix:p,ref:A,onBlur:C,disabled:e.disabled||c,min:0,max:1e14};return(0,element_1.createElement)("div",{...l},(0,element_1.createElement)("h4",null,(0,i18n_1.__)("Dimensions","woocommerce")),(0,element_1.createElement)("div",{className:"wp-block-columns"},(0,element_1.createElement)("div",{className:"wp-block-column"},(0,element_1.createElement)(number_control_1.NumberControl,{label:(0,element_1.createInterpolateElement)((0,i18n_1.__)("Width <Side />","woocommerce"),{Side:(0,element_1.createElement)("span",null,"A")}),error:b,...k}),(0,element_1.createElement)(number_control_1.NumberControl,{label:(0,element_1.createInterpolateElement)((0,i18n_1.__)("Length <Side />","woocommerce"),{Side:(0,element_1.createElement)("span",null,"B")}),error:N,...W}),(0,element_1.createElement)(number_control_1.NumberControl,{label:(0,element_1.createInterpolateElement)((0,i18n_1.__)("Height <Side />","woocommerce"),{Side:(0,element_1.createElement)("span",null,"C")}),error:P,...H}),(0,element_1.createElement)(number_control_1.NumberControl,{label:(0,i18n_1.__)("Weight","woocommerce"),error:B,...U})),(0,element_1.createElement)("div",{className:"wp-block-column"},(0,element_1.createElement)(shipping_dimensions_image_1.ShippingDimensionsImage,{highlight:d,className:"wp-block-woocommerce-product-shipping-dimensions-fields__dimensions-image",labels:{A:(null===(o=k.value)||void 0===o?void 0:o.length)?k.value:void 0,B:(null===(i=W.value)||void 0===i?void 0:i.length)?W.value:void 0,C:(null===(r=H.value)||void 0===r?void 0:r.length)?H.value:void 0}}))))}exports.Edit=Edit;