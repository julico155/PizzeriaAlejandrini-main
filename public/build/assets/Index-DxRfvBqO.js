import{_ as m}from"./AuthenticatedLayout-HKoGgz7W.js";import{_ as c}from"./VisitasFooter-Dp7SydDu.js";import d from"./PizzaSearch-rkeTUwBK.js";import{j as p,q as u,f as _,a as t,u as f,w as n,F as w,o as z,Z as x,b as o}from"./app-BbmtW1sE.js";import v from"./Pizzas-D4TkL8g2.js";import"./ApplicationLogo-CaqONJNU.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./TextInput-Cc_RDQWf.js";import"./Pizza-D7UNeMWW.js";import"./CustomButton-Pl8QP58P.js";const g={class:"py-12"},h={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},C={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},L={class:"p-6 text-gray-900"},V={__name:"Index",props:{pizzas:{type:Array,required:!0},visitas:{type:Object,required:!0}},setup(i){const r=i,a=p([]);u(()=>{a.value=r.pizzas});const l=e=>{a.value=r.pizzas.filter(s=>s.nombre.toLowerCase().includes(e.toLowerCase())||s.descripcion.toLowerCase().includes(e.toLowerCase())||s.tamano.toLowerCase().includes(e.toLowerCase())||s.categoria.toLowerCase().includes(e.toLowerCase()))};return(e,s)=>(z(),_(w,null,[t(f(x),{title:"Pizzas"}),t(m,null,{header:n(()=>s[0]||(s[0]=[o("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Pizzas ",-1)])),default:n(()=>[o("div",g,[o("div",h,[o("div",C,[o("div",L,[t(d,{onSearchPizzas:l}),t(v,{pizzas:a.value},null,8,["pizzas"])])])])]),t(c,{visitas:i.visitas.cant},null,8,["visitas"])]),_:1})],64))}};export{V as default};