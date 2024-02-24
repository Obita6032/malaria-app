/**
 * Highstock JS v11.3.0 (2024-01-10)
 *
 * Indicator series type for Highcharts Stock
 *
 * (c) 2010-2024 Wojciech Chmiel
 *
 * License: www.highcharts.com/license
 */!function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/indicators/williams-r",["highcharts","highcharts/modules/stock"],function(e){return t(e),t.Highcharts=e,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var e=t?t._modules:{};function r(t,e,r,i){t.hasOwnProperty(e)||(t[e]=i.apply(null,r),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:e,module:t[e]}})))}r(e,"Stock/Indicators/ArrayUtilities.js",[],function(){return{getArrayExtremes:function(t,e,r){return t.reduce(function(t,i){return[Math.min(t[0],i[e]),Math.max(t[1],i[r])]},[Number.MAX_VALUE,-Number.MAX_VALUE])}}}),r(e,"Stock/Indicators/WilliamsR/WilliamsRIndicator.js",[e["Stock/Indicators/ArrayUtilities.js"],e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e,r){var i,n=this&&this.__extends||(i=function(t,e){return(i=Object.setPrototypeOf||({__proto__:[]})instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r])})(t,e)},function(t,e){if("function"!=typeof e&&null!==e)throw TypeError("Class extends value "+String(e)+" is not a constructor or null");function r(){this.constructor=t}i(t,e),t.prototype=null===e?Object.create(e):(r.prototype=e.prototype,new r)}),o=e.seriesTypes.sma,s=r.extend,a=r.isArray,u=r.merge,c=function(e){function r(){return null!==e&&e.apply(this,arguments)||this}return n(r,e),r.prototype.getValues=function(e,r){var i,n,o,s,u,c,l=r.period,p=e.xData,f=e.yData,d=f?f.length:0,h=[],y=[],m=[];if(!(p.length<l)&&a(f[0])&&4===f[0].length){for(c=l-1;c<d;c++)i=f.slice(c-l+1,c+1),u=(n=t.getArrayExtremes(i,2,1))[0],o=-(((s=n[1])-f[c][3])/(s-u)*100),p[c]&&(h.push([p[c],o]),y.push(p[c]),m.push(o));return{values:h,xData:y,yData:m}}},r.defaultOptions=u(o.defaultOptions,{params:{index:void 0,period:14}}),r}(o);return s(c.prototype,{nameBase:"Williams %R"}),e.registerSeriesType("williamsr",c),c}),r(e,"masters/indicators/williams-r.src.js",[],function(){})});