import{f as o,b as t,F as n,k as d,o as l,t as s}from"./app-BbmtW1sE.js";const p={class:"p-6 lg:p-8 bg-white border-b border-gray-200"},_={class:"bg-gray-200 rounded-lg"},h={class:"w-full"},x={class:"px-6 py-4 text-center"},i={class:"px-6 py-4 text-center"},y={class:"px-6 py-4 text-center"},b={class:"px-6 py-4 text-center"},u={class:"px-6 py-4 text-center"},g={class:"px-6 py-4 text-center"},m={class:"px-6 py-4 text-center"},f=["onClick"],w={__name:"Pedidos",props:{pedidos:{type:Array,required:!0}},setup(r){return(c,a)=>(l(),o("div",p,[t("div",_,[t("table",h,[a[0]||(a[0]=t("thead",null,[t("tr",null,[t("th",{class:"px-3 py-3"},"#"),t("th",{class:"px-3 py-3"},"Fecha"),t("th",{class:"px-3 py-3"},"Total"),t("th",{class:"px-3 py-3"},"Metodo de pago"),t("th",{class:"px-3 py-3"},"Estado"),t("th",{class:"px-3 py-3"},"Estado del pago"),t("th",{class:"px-3 py-3"},"Detalles")])],-1)),t("tbody",null,[(l(!0),o(n,null,d(r.pedidos,e=>(l(),o("tr",{class:"border-t border-gray-200",key:e.id},[t("td",x,s(e.id),1),t("td",i,s(e.fecha_literal),1),t("td",y,s(e.total),1),t("td",b,s(e.pago_metodo.nombre),1),t("td",u,s(e.pedido_estado.nombre),1),t("td",g,s(e.pago_estado.nombre),1),t("td",m,[t("button",{class:"bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full",onClick:k=>c.$emit("showDetalles",{detalles:e.detalles,total:e.total})}," Ver ",8,f)])]))),128))])])])]))}};export{w as default};
