"use strict";var __importDefault=this&&this.__importDefault||function(e){return e&&e.__esModule?e:{default:e}};Object.defineProperty(exports,"__esModule",{value:!0}),exports.Edit=void 0;const classnames_1=__importDefault(require("classnames")),block_templates_1=require("@woocommerce/block-templates"),compose_1=require("@wordpress/compose"),core_data_1=require("@wordpress/core-data"),element_1=require("@wordpress/element"),i18n_1=require("@wordpress/i18n"),components_1=require("@wordpress/components"),validation_context_1=require("../../../contexts/validation-context"),use_currency_input_props_1=require("../../../hooks/use-currency-input-props"),label_1=require("../../../components/label/label");function Edit({attributes:e,clientId:t,context:r}){const o=(0,block_templates_1.useWooBlockProps)(e),{label:s,help:a,tooltip:n,disabled:l}=e,[c]=(0,core_data_1.useEntityProp)("postType",r.postType||"product","regular_price"),[p,i]=(0,core_data_1.useEntityProp)("postType",r.postType||"product","sale_price"),u=(0,use_currency_input_props_1.useCurrencyInputProps)({value:p,onChange:i}),_=(0,compose_1.useInstanceId)(components_1.BaseControl,"wp-block-woocommerce-product-sale-price-field"),{ref:m,error:d,validate:b}=(0,validation_context_1.useValidation)(`sale-price-${t}`,(async function(){if(p){if(Number.parseFloat(p)<0)return{message:(0,i18n_1.__)("Sale price must be greater than or equals to zero.","woocommerce"),context:t};const e=Number.parseFloat(c);if(!e||e<=Number.parseFloat(p))return{message:(0,i18n_1.__)("Sale price must be lower than the regular price.","woocommerce"),context:t}}}),[c,p]);return(0,element_1.createElement)("div",{...o},(0,element_1.createElement)(components_1.BaseControl,{id:_,help:d||a,className:(0,classnames_1.default)({"has-error":d})},(0,element_1.createElement)(components_1.__experimentalInputControl,{...u,id:_,name:"sale_price",inputMode:"decimal",ref:m,label:n?(0,element_1.createElement)(label_1.Label,{label:s,tooltip:n}):s,disabled:l,onBlur:b})))}exports.Edit=Edit;