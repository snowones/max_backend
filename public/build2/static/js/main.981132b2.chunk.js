(this.webpackJsonpnews=this.webpackJsonpnews||[]).push([[0],{103:function(e,t,a){e.exports=a(188)},108:function(e,t,a){},161:function(e,t,a){},168:function(e,t,a){},186:function(e,t,a){},187:function(e,t,a){},188:function(e,t,a){"use strict";a.r(t);var n=a(0),l=a.n(n),c=a(9),r=a.n(c),o=(a(108),a(16)),i=a(20),m=a(56),s=a(38),u=a(44),E=a(23),p=a(192),d=a(193),h=(a(77),function(e){return l.a.createElement(p.a,{mode:"horizontal",selectedKeys:[e.current],style:{background:"#f0f2f5"},onClick:e.menuItemClick},l.a.createElement(p.a.Item,{key:"index",icon:l.a.createElement(d.a,null)},l.a.createElement(i.b,{to:"/index"},"\u4e3b\u9875")),l.a.createElement(p.a.Item,{key:"artcle",icon:l.a.createElement(d.a,null)},l.a.createElement(i.b,{to:"/artcle"},"\u6587\u7ae0")),l.a.createElement(p.a.Item,{key:"posting",icon:l.a.createElement(d.a,null)},l.a.createElement(i.b,{to:"/posting"},"\u5e16\u5b50")),l.a.createElement(p.a.Item,{key:"login",icon:l.a.createElement(d.a,null)},l.a.createElement(i.b,{to:"/login"},"\u767b\u5f55")))}),g=function(){var e=Object(n.useState)("mail"),t=Object(s.a)(e,2),a=t[0],c=t[1];return l.a.createElement("div",{className:"new-header"},l.a.createElement("header",null,l.a.createElement(u.a,null,l.a.createElement(E.a,{span:2}),l.a.createElement(E.a,{span:4},l.a.createElement("a",{className:"logo",href:"/"},l.a.createElement("img",{src:"https://1978246522-max.oss-cn-hangzhou.aliyuncs.com/logo.png",alt:"logo"}),l.a.createElement("span",null,"\u65b0\u95fb"))),l.a.createElement(E.a,{span:18},l.a.createElement(h,{current:a,menuItemClick:function(e){c(e.key)}})))))},y=a(190),f=y.a.Footer,b=function(e){return l.a.createElement(f,{style:{textAlign:"center"}},"News Web \xa92020 Created by ZYX")},v=(a(161),y.a.Content),w=function(e){return l.a.createElement(y.a,{className:"layout"},l.a.createElement(g,null),l.a.createElement(v,{style:{padding:"0 50px"}},l.a.createElement("div",{className:"site-layout-content"},Object(m.a)(e.route.children))),l.a.createElement(b,null))},_=a(74),k={api:function(e){var t=e.url,a=e.args,n=void 0===a?"":a,l=e.callback,c="";if(""!=n){for(var r in n)c+=r+"="+n[r]+"&";c="?"+c.substr(0,c.length-1)}fetch(t+c).then((function(e){return e.json()})).then((function(e){l(e)}))},time:function(e){return e=parseInt(e),new Date(e+288e5).toJSON().substr(0,19).replace("T"," ")}},T=k.api.bind(k),N="http://182.92.64.245/tp5/public/index.php/index/index/",j=(k.time.bind(k),_.a.TabPane),O=function(e){var t=Object(n.useState)([]),a=Object(s.a)(t,2),c=a[0],r=a[1];Object(n.useEffect)((function(){e.type;T({url:N+"newsSelectContentByType",args:{type:1},callback:function(e){console.log(e),o(e)}})}),[]);var o=function(e){for(var t=[],a=0;a<e.length;a++){JSON.parse(e[a].img);t.push({uniquekey:e[a].id,title:e[a].title})}r(t)},m=function(){console.log(c);var e=c.map((function(e,t){return l.a.createElement("li",{key:t},l.a.createElement(i.b,{to:"details/".concat(e.uniquekey),target:"_blank"},e.title))}));return l.a.createElement("ul",null,e)};return l.a.createElement("div",null,l.a.createElement(_.a,{defaultActiveKey:"1",onChange:function(e){console.log(e)}},l.a.createElement(j,{tab:"\u70ed\u70b9\u6587\u7ae0",key:"1"},l.a.createElement(m,null)),l.a.createElement(j,{tab:"\u70ed\u70b9\u5e16\u5b50",key:"2"},l.a.createElement(m,null)),l.a.createElement(j,{tab:"\u56fd\u9645\u65b0\u95fb",key:"3"},l.a.createElement(m,null)),l.a.createElement(j,{tab:"\u56fd\u5185\u65b0\u95fb",key:"4"},l.a.createElement(m,null))))},x=a(191),C=a(194),S=(a(168),function(e){var t=Object(n.useState)(""),a=Object(s.a)(t,2),c=a[0],r=a[1];Object(n.useEffect)((function(){var t=e.type;T({url:N+"newsSelectContentByType",args:{type:1,wenzhangType:t},callback:function(e){console.log(e),o(e)}})}),[]);var o=function(t){for(var a=[],n=0;n<e.count;n++){var l=JSON.parse(t[n].img);a.push({uniquekey:t[n].id,thumbnail_pic_s:l[0],title:t[n].title,author_name:t[n].name})}r(a)};return l.a.createElement("div",{className:"pc_news_imgblock"},function(){if(c.length){var t="";return 1==e.componentType?t=c.map((function(t,a){return l.a.createElement("div",{key:a,className:"image_news_item",style:{width:e.imageWidth}},l.a.createElement(i.b,{to:"details/".concat(t.uniquekey),target:"_blank"},l.a.createElement("img",{alt:"newsItem.title",src:t.thumbnail_pic_s,width:e.imageWidth}),l.a.createElement("h3",null,t.title),l.a.createElement("p",null,t.author_name)))})):2==e.componentType&&(t=c.map((function(t,a){return l.a.createElement(i.b,{to:"details/".concat(t.uniquekey),target:"_blank",key:a},l.a.createElement("section",{className:"imageSingle_sec",style:{width:e.width}},l.a.createElement("div",{className:"imageSingle_left",style:{width:e.ImageWidth}},l.a.createElement("img",{style:{width:e.ImageWidth},src:t.thumbnail_pic_s,alt:t.title})),l.a.createElement("div",{className:"imageSingle_right"},l.a.createElement("p",null,t.title),l.a.createElement("span",{className:"realType"},t.realtype),l.a.createElement("span",null,t.author_name))))}))),l.a.createElement(C.a,{className:"2"==e.componentType?"imageSingleCard":"image_card",title:e.cartTitle,bordered:!0,style:{width:e.width,marginTop:"10px"}},l.a.createElement("div",{className:"image_news_container",style:{width:e.width,justifyContent:e.justifyContent}},t))}return"\u6b63\u5728\u52a0\u8f7d"}())}),I=function(e){return l.a.createElement("div",null,l.a.createElement(x.a,{autoplay:!0},l.a.createElement("div",null,l.a.createElement("img",{src:"https://zyx-news.oss-cn-hangzhou.aliyuncs.com/news1.jpg"})),l.a.createElement("div",null,l.a.createElement("img",{src:"https://zyx-news.oss-cn-hangzhou.aliyuncs.com/news2.jpg"})),l.a.createElement("div",null,l.a.createElement("img",{src:"https://zyx-news.oss-cn-hangzhou.aliyuncs.com/news3.jpg"})),l.a.createElement("div",null,l.a.createElement("img",{src:"https://zyx-news.oss-cn-hangzhou.aliyuncs.com/news4.jpg"}))),l.a.createElement(S,{count:10,type:"4",width:"100%",imageWidth:"112px",cartTitle:"\u7f8e\u56fd\u5927\u66b4\u52a8",justifyContent:"space-around",componentType:"1"}))},W=function(e){return l.a.createElement("div",null,l.a.createElement(S,{count:12,type:"2",width:"100%",imageWidth:"112px",cartTitle:"R.I.P Kobe",justifyContent:"space-start",componentType:"1"}))},P=function(e){return l.a.createElement("div",null,l.a.createElement(S,{width:"100%",ImageWidth:"100px",type:"3",count:5,cartTitle:"\u6d77\u8d3c\u738b",componentType:"2"}))},z=(a(186),function(e){return Object(n.useEffect)((function(){console.log("111"),console.log(Object({NODE_ENV:"production",PUBLIC_URL:"/tp5/public/build2",WDS_SOCKET_HOST:void 0,WDS_SOCKET_PATH:void 0,WDS_SOCKET_PORT:void 0})),console.log(Object({REACT_APP_API:"http:192.168.1.1"}))}),[]),l.a.createElement("div",{className:"index"},l.a.createElement(u.a,null,l.a.createElement(E.a,{span:2}),l.a.createElement(E.a,{span:21},l.a.createElement(u.a,{className:"top_news"},l.a.createElement(E.a,{span:8},l.a.createElement("div",{className:"top_left top"},l.a.createElement(I,null))),l.a.createElement(E.a,{span:7},l.a.createElement("div",{className:"top_center top"},l.a.createElement(O,null))),l.a.createElement(E.a,{span:6},l.a.createElement("div",{className:"top_right top"},l.a.createElement(P,null)))),l.a.createElement(u.a,null,l.a.createElement("div",{className:"bottom"},l.a.createElement(W,null)))),l.a.createElement(E.a,{span:4})))}),A=(a(187),_.a.TabPane),K=[{path:"/",component:w,children:[{path:"/",exact:!0,component:z},{path:"/index",exact:!0,component:z},{path:"/posting",exact:!0,component:function(e){return l.a.createElement("div",null,l.a.createElement(_.a,{defaultActiveKey:"1",onChange:function(e){console.log(e)}},l.a.createElement(A,{tab:"Tab 1",key:"1"},"Content of Tab Pane 1"),l.a.createElement(A,{tab:"Tab 2",key:"2"},"Content of Tab Pane 2"),l.a.createElement(A,{tab:"Tab 3",key:"3"},"Content of Tab Pane 3")))}}]}],q=Object(o.b)();var B=function(){return l.a.createElement("div",{className:"App"},l.a.createElement(i.a,{history:q},Object(m.a)(K)))};Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));r.a.render(l.a.createElement(B,null),document.getElementById("root")),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()})).catch((function(e){console.error(e.message)}))},77:function(e,t,a){}},[[103,1,2]]]);
//# sourceMappingURL=main.981132b2.chunk.js.map