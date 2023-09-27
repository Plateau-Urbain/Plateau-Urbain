// â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â” \\
// â”‚ RaphaÃ«l 2.1.4 - JavaScript Vector Library                          â”‚ \\
// â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤ \\
// â”‚ Copyright Â© 2008-2012 Dmitry Baranovskiy (http://raphaeljs.com)    â”‚ \\
// â”‚ Copyright Â© 2008-2012 Sencha Labs (http://sencha.com)              â”‚ \\
// â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤ \\
// â”‚ Licensed under the MIT (http://raphaeljs.com/license.html) license.â”‚ \\
// â””â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜ \\
!function(a){var b,c,d="0.4.2",e="hasOwnProperty",f=/[\.\/]/,g="*",h=function(){},i=function(a,b){return a-b},j={n:{}},k=function(a,d){a=String(a);var e,f=c,g=Array.prototype.slice.call(arguments,2),h=k.listeners(a),j=0,l=[],m={},n=[],o=b;b=a,c=0;for(var p=0,q=h.length;q>p;p++)"zIndex"in h[p]&&(l.push(h[p].zIndex),h[p].zIndex<0&&(m[h[p].zIndex]=h[p]));for(l.sort(i);l[j]<0;)if(e=m[l[j++]],n.push(e.apply(d,g)),c)return c=f,n;for(p=0;q>p;p++)if(e=h[p],"zIndex"in e)if(e.zIndex==l[j]){if(n.push(e.apply(d,g)),c)break;do if(j++,e=m[l[j]],e&&n.push(e.apply(d,g)),c)break;while(e)}else m[e.zIndex]=e;else if(n.push(e.apply(d,g)),c)break;return c=f,b=o,n.length?n:null};k._events=j,k.listeners=function(a){var b,c,d,e,h,i,k,l,m=a.split(f),n=j,o=[n],p=[];for(e=0,h=m.length;h>e;e++){for(l=[],i=0,k=o.length;k>i;i++)for(n=o[i].n,c=[n[m[e]],n[g]],d=2;d--;)b=c[d],b&&(l.push(b),p=p.concat(b.f||[]));o=l}return p},k.on=function(a,b){if(a=String(a),"function"!=typeof b)return function(){};for(var c=a.split(f),d=j,e=0,g=c.length;g>e;e++)d=d.n,d=d.hasOwnProperty(c[e])&&d[c[e]]||(d[c[e]]={n:{}});for(d.f=d.f||[],e=0,g=d.f.length;g>e;e++)if(d.f[e]==b)return h;return d.f.push(b),function(a){+a==+a&&(b.zIndex=+a)}},k.f=function(a){var b=[].slice.call(arguments,1);return function(){k.apply(null,[a,null].concat(b).concat([].slice.call(arguments,0)))}},k.stop=function(){c=1},k.nt=function(a){return a?new RegExp("(?:\\.|\\/|^)"+a+"(?:\\.|\\/|$)").test(b):b},k.nts=function(){return b.split(f)},k.off=k.unbind=function(a,b){if(!a)return void(k._events=j={n:{}});var c,d,h,i,l,m,n,o=a.split(f),p=[j];for(i=0,l=o.length;l>i;i++)for(m=0;m<p.length;m+=h.length-2){if(h=[m,1],c=p[m].n,o[i]!=g)c[o[i]]&&h.push(c[o[i]]);else for(d in c)c[e](d)&&h.push(c[d]);p.splice.apply(p,h)}for(i=0,l=p.length;l>i;i++)for(c=p[i];c.n;){if(b){if(c.f){for(m=0,n=c.f.length;n>m;m++)if(c.f[m]==b){c.f.splice(m,1);break}!c.f.length&&delete c.f}for(d in c.n)if(c.n[e](d)&&c.n[d].f){var q=c.n[d].f;for(m=0,n=q.length;n>m;m++)if(q[m]==b){q.splice(m,1);break}!q.length&&delete c.n[d].f}}else{delete c.f;for(d in c.n)c.n[e](d)&&c.n[d].f&&delete c.n[d].f}c=c.n}},k.once=function(a,b){var c=function(){return k.unbind(a,c),b.apply(this,arguments)};return k.on(a,c)},k.version=d,k.toString=function(){return"You are running Eve "+d},"undefined"!=typeof module&&module.exports?module.exports=k:"undefined"!=typeof define?define("eve",[],function(){return k}):a.eve=k}(window||this),function(a,b){"function"==typeof define&&define.amd?define(["eve"],function(c){return b(a,c)}):b(a,a.eve||"function"==typeof require&&require("eve"))}(this,function(a,b){function c(a){if(c.is(a,"function"))return u?a():b.on("raphael.DOMload",a);if(c.is(a,V))return c._engine.create[D](c,a.splice(0,3+c.is(a[0],T))).add(a);var d=Array.prototype.slice.call(arguments,0);if(c.is(d[d.length-1],"function")){var e=d.pop();return u?e.call(c._engine.create[D](c,d)):b.on("raphael.DOMload",function(){e.call(c._engine.create[D](c,d))})}return c._engine.create[D](c,arguments)}function d(a){if("function"==typeof a||Object(a)!==a)return a;var b=new a.constructor;for(var c in a)a[z](c)&&(b[c]=d(a[c]));return b}function e(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return a.push(a.splice(c,1)[0])}function f(a,b,c){function d(){var f=Array.prototype.slice.call(arguments,0),g=f.join("â€"),h=d.cache=d.cache||{},i=d.count=d.count||[];return h[z](g)?(e(i,g),c?c(h[g]):h[g]):(i.length>=1e3&&delete h[i.shift()],i.push(g),h[g]=a[D](b,f),c?c(h[g]):h[g])}return d}function g(){return this.hex}function h(a,b){for(var c=[],d=0,e=a.length;e-2*!b>d;d+=2){var f=[{x:+a[d-2],y:+a[d-1]},{x:+a[d],y:+a[d+1]},{x:+a[d+2],y:+a[d+3]},{x:+a[d+4],y:+a[d+5]}];b?d?e-4==d?f[3]={x:+a[0],y:+a[1]}:e-2==d&&(f[2]={x:+a[0],y:+a[1]},f[3]={x:+a[2],y:+a[3]}):f[0]={x:+a[e-2],y:+a[e-1]}:e-4==d?f[3]=f[2]:d||(f[0]={x:+a[d],y:+a[d+1]}),c.push(["C",(-f[0].x+6*f[1].x+f[2].x)/6,(-f[0].y+6*f[1].y+f[2].y)/6,(f[1].x+6*f[2].x-f[3].x)/6,(f[1].y+6*f[2].y-f[3].y)/6,f[2].x,f[2].y])}return c}function i(a,b,c,d,e){var f=-3*b+9*c-9*d+3*e,g=a*f+6*b-12*c+6*d;return a*g-3*b+3*c}function j(a,b,c,d,e,f,g,h,j){null==j&&(j=1),j=j>1?1:0>j?0:j;for(var k=j/2,l=12,m=[-.1252,.1252,-.3678,.3678,-.5873,.5873,-.7699,.7699,-.9041,.9041,-.9816,.9816],n=[.2491,.2491,.2335,.2335,.2032,.2032,.1601,.1601,.1069,.1069,.0472,.0472],o=0,p=0;l>p;p++){var q=k*m[p]+k,r=i(q,a,c,e,g),s=i(q,b,d,f,h),t=r*r+s*s;o+=n[p]*N.sqrt(t)}return k*o}function k(a,b,c,d,e,f,g,h,i){if(!(0>i||j(a,b,c,d,e,f,g,h)<i)){var k,l=1,m=l/2,n=l-m,o=.01;for(k=j(a,b,c,d,e,f,g,h,n);Q(k-i)>o;)m/=2,n+=(i>k?1:-1)*m,k=j(a,b,c,d,e,f,g,h,n);return n}}function l(a,b,c,d,e,f,g,h){if(!(O(a,c)<P(e,g)||P(a,c)>O(e,g)||O(b,d)<P(f,h)||P(b,d)>O(f,h))){var i=(a*d-b*c)*(e-g)-(a-c)*(e*h-f*g),j=(a*d-b*c)*(f-h)-(b-d)*(e*h-f*g),k=(a-c)*(f-h)-(b-d)*(e-g);if(k){var l=i/k,m=j/k,n=+l.toFixed(2),o=+m.toFixed(2);if(!(n<+P(a,c).toFixed(2)||n>+O(a,c).toFixed(2)||n<+P(e,g).toFixed(2)||n>+O(e,g).toFixed(2)||o<+P(b,d).toFixed(2)||o>+O(b,d).toFixed(2)||o<+P(f,h).toFixed(2)||o>+O(f,h).toFixed(2)))return{x:l,y:m}}}}function m(a,b,d){var e=c.bezierBBox(a),f=c.bezierBBox(b);if(!c.isBBoxIntersect(e,f))return d?0:[];for(var g=j.apply(0,a),h=j.apply(0,b),i=O(~~(g/5),1),k=O(~~(h/5),1),m=[],n=[],o={},p=d?0:[],q=0;i+1>q;q++){var r=c.findDotsAtSegment.apply(c,a.concat(q/i));m.push({x:r.x,y:r.y,t:q/i})}for(q=0;k+1>q;q++)r=c.findDotsAtSegment.apply(c,b.concat(q/k)),n.push({x:r.x,y:r.y,t:q/k});for(q=0;i>q;q++)for(var s=0;k>s;s++){var t=m[q],u=m[q+1],v=n[s],w=n[s+1],x=Q(u.x-t.x)<.001?"y":"x",y=Q(w.x-v.x)<.001?"y":"x",z=l(t.x,t.y,u.x,u.y,v.x,v.y,w.x,w.y);if(z){if(o[z.x.toFixed(4)]==z.y.toFixed(4))continue;o[z.x.toFixed(4)]=z.y.toFixed(4);var A=t.t+Q((z[x]-t[x])/(u[x]-t[x]))*(u.t-t.t),B=v.t+Q((z[y]-v[y])/(w[y]-v[y]))*(w.t-v.t);A>=0&&1.001>=A&&B>=0&&1.001>=B&&(d?p++:p.push({x:z.x,y:z.y,t1:P(A,1),t2:P(B,1)}))}}return p}function n(a,b,d){a=c._path2curve(a),b=c._path2curve(b);for(var e,f,g,h,i,j,k,l,n,o,p=d?0:[],q=0,r=a.length;r>q;q++){var s=a[q];if("M"==s[0])e=i=s[1],f=j=s[2];else{"C"==s[0]?(n=[e,f].concat(s.slice(1)),e=n[6],f=n[7]):(n=[e,f,e,f,i,j,i,j],e=i,f=j);for(var t=0,u=b.length;u>t;t++){var v=b[t];if("M"==v[0])g=k=v[1],h=l=v[2];else{"C"==v[0]?(o=[g,h].concat(v.slice(1)),g=o[6],h=o[7]):(o=[g,h,g,h,k,l,k,l],g=k,h=l);var w=m(n,o,d);if(d)p+=w;else{for(var x=0,y=w.length;y>x;x++)w[x].segment1=q,w[x].segment2=t,w[x].bez1=n,w[x].bez2=o;p=p.concat(w)}}}}}return p}function o(a,b,c,d,e,f){null!=a?(this.a=+a,this.b=+b,this.c=+c,this.d=+d,this.e=+e,this.f=+f):(this.a=1,this.b=0,this.c=0,this.d=1,this.e=0,this.f=0)}function p(){return this.x+H+this.y+H+this.width+" Ã— "+this.height}function q(a,b,c,d,e,f){function g(a){return((l*a+k)*a+j)*a}function h(a,b){var c=i(a,b);return((o*c+n)*c+m)*c}function i(a,b){var c,d,e,f,h,i;for(e=a,i=0;8>i;i++){if(f=g(e)-a,Q(f)<b)return e;if(h=(3*l*e+2*k)*e+j,Q(h)<1e-6)break;e-=f/h}if(c=0,d=1,e=a,c>e)return c;if(e>d)return d;for(;d>c;){if(f=g(e),Q(f-a)<b)return e;a>f?c=e:d=e,e=(d-c)/2+c}return e}var j=3*b,k=3*(d-b)-j,l=1-j-k,m=3*c,n=3*(e-c)-m,o=1-m-n;return h(a,1/(200*f))}function r(a,b){var c=[],d={};if(this.ms=b,this.times=1,a){for(var e in a)a[z](e)&&(d[_(e)]=a[e],c.push(_(e)));c.sort(lb)}this.anim=d,this.top=c[c.length-1],this.percents=c}function s(a,d,e,f,g,h){e=_(e);var i,j,k,l,m,n,p=a.ms,r={},s={},t={};if(f)for(v=0,x=ic.length;x>v;v++){var u=ic[v];if(u.el.id==d.id&&u.anim==a){u.percent!=e?(ic.splice(v,1),k=1):j=u,d.attr(u.totalOrigin);break}}else f=+s;for(var v=0,x=a.percents.length;x>v;v++){if(a.percents[v]==e||a.percents[v]>f*a.top){e=a.percents[v],m=a.percents[v-1]||0,p=p/a.top*(e-m),l=a.percents[v+1],i=a.anim[e];break}f&&d.attr(a.anim[a.percents[v]])}if(i){if(j)j.initstatus=f,j.start=new Date-j.ms*f;else{for(var y in i)if(i[z](y)&&(db[z](y)||d.paper.customAttributes[z](y)))switch(r[y]=d.attr(y),null==r[y]&&(r[y]=cb[y]),s[y]=i[y],db[y]){case T:t[y]=(s[y]-r[y])/p;break;case"colour":r[y]=c.getRGB(r[y]);var A=c.getRGB(s[y]);t[y]={r:(A.r-r[y].r)/p,g:(A.g-r[y].g)/p,b:(A.b-r[y].b)/p};break;case"path":var B=Kb(r[y],s[y]),C=B[1];for(r[y]=B[0],t[y]=[],v=0,x=r[y].length;x>v;v++){t[y][v]=[0];for(var D=1,F=r[y][v].length;F>D;D++)t[y][v][D]=(C[v][D]-r[y][v][D])/p}break;case"transform":var G=d._,H=Pb(G[y],s[y]);if(H)for(r[y]=H.from,s[y]=H.to,t[y]=[],t[y].real=!0,v=0,x=r[y].length;x>v;v++)for(t[y][v]=[r[y][v][0]],D=1,F=r[y][v].length;F>D;D++)t[y][v][D]=(s[y][v][D]-r[y][v][D])/p;else{var K=d.matrix||new o,L={_:{transform:G.transform},getBBox:function(){return d.getBBox(1)}};r[y]=[K.a,K.b,K.c,K.d,K.e,K.f],Nb(L,s[y]),s[y]=L._.transform,t[y]=[(L.matrix.a-K.a)/p,(L.matrix.b-K.b)/p,(L.matrix.c-K.c)/p,(L.matrix.d-K.d)/p,(L.matrix.e-K.e)/p,(L.matrix.f-K.f)/p]}break;case"csv":var M=I(i[y])[J](w),N=I(r[y])[J](w);if("clip-rect"==y)for(r[y]=N,t[y]=[],v=N.length;v--;)t[y][v]=(M[v]-r[y][v])/p;s[y]=M;break;default:for(M=[][E](i[y]),N=[][E](r[y]),t[y]=[],v=d.paper.customAttributes[y].length;v--;)t[y][v]=((M[v]||0)-(N[v]||0))/p}var O=i.easing,P=c.easing_formulas[O];if(!P)if(P=I(O).match(Z),P&&5==P.length){var Q=P;P=function(a){return q(a,+Q[1],+Q[2],+Q[3],+Q[4],p)}}else P=nb;if(n=i.start||a.start||+new Date,u={anim:a,percent:e,timestamp:n,start:n+(a.del||0),status:0,initstatus:f||0,stop:!1,ms:p,easing:P,from:r,diff:t,to:s,el:d,callback:i.callback,prev:m,next:l,repeat:h||a.times,origin:d.attr(),totalOrigin:g},ic.push(u),f&&!j&&!k&&(u.stop=!0,u.start=new Date-p*f,1==ic.length))return kc();k&&(u.start=new Date-u.ms*f),1==ic.length&&jc(kc)}b("raphael.anim.start."+d.id,d,a)}}function t(a){for(var b=0;b<ic.length;b++)ic[b].el.paper==a&&ic.splice(b--,1)}c.version="2.1.2",c.eve=b;var u,v,w=/[, ]+/,x={circle:1,rect:1,path:1,ellipse:1,text:1,image:1},y=/\{(\d+)\}/g,z="hasOwnProperty",A={doc:document,win:a},B={was:Object.prototype[z].call(A.win,"Raphael"),is:A.win.Raphael},C=function(){this.ca=this.customAttributes={}},D="apply",E="concat",F="ontouchstart"in A.win||A.win.DocumentTouch&&A.doc instanceof DocumentTouch,G="",H=" ",I=String,J="split",K="click dblclick mousedown mousemove mouseout mouseover mouseup touchstart touchmove touchend touchcancel"[J](H),L={mousedown:"touchstart",mousemove:"touchmove",mouseup:"touchend"},M=I.prototype.toLowerCase,N=Math,O=N.max,P=N.min,Q=N.abs,R=N.pow,S=N.PI,T="number",U="string",V="array",W=Object.prototype.toString,X=(c._ISURL=/^url\(['"]?(.+?)['"]?\)$/i,/^\s*((#[a-f\d]{6})|(#[a-f\d]{3})|rgba?\(\s*([\d\.]+%?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+%?(?:\s*,\s*[\d\.]+%?)?)\s*\)|hsba?\(\s*([\d\.]+(?:deg|\xb0|%)?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+(?:%?\s*,\s*[\d\.]+)?)%?\s*\)|hsla?\(\s*([\d\.]+(?:deg|\xb0|%)?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+(?:%?\s*,\s*[\d\.]+)?)%?\s*\))\s*$/i),Y={NaN:1,Infinity:1,"-Infinity":1},Z=/^(?:cubic-)?bezier\(([^,]+),([^,]+),([^,]+),([^\)]+)\)/,$=N.round,_=parseFloat,ab=parseInt,bb=I.prototype.toUpperCase,cb=c._availableAttrs={"arrow-end":"none","arrow-start":"none",blur:0,"clip-rect":"0 0 1e9 1e9",cursor:"default",cx:0,cy:0,fill:"#fff","fill-opacity":1,font:'10px "Arial"',"font-family":'"Arial"',"font-size":"10","font-style":"normal","font-weight":400,gradient:0,height:0,href:"http://raphaeljs.com/","letter-spacing":0,opacity:1,path:"M0,0",r:0,rx:0,ry:0,src:"",stroke:"#000","stroke-dasharray":"","stroke-linecap":"butt","stroke-linejoin":"butt","stroke-miterlimit":0,"stroke-opacity":1,"stroke-width":1,target:"_blank","text-anchor":"middle",title:"Raphael",transform:"",width:0,x:0,y:0},db=c._availableAnimAttrs={blur:T,"clip-rect":"csv",cx:T,cy:T,fill:"colour","fill-opacity":T,"font-size":T,height:T,opacity:T,path:"path",r:T,rx:T,ry:T,stroke:"colour","stroke-opacity":T,"stroke-width":T,transform:"transform",width:T,x:T,y:T},eb=/[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*/,fb={hs:1,rg:1},gb=/,?([achlmqrstvxz]),?/gi,hb=/([achlmrqstvz])[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029,]*((-?\d*\.?\d*(?:e[\-+]?\d+)?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*)+)/gi,ib=/([rstm])[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029,]*((-?\d*\.?\d*(?:e[\-+]?\d+)?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*)+)/gi,jb=/(-?\d*\.?\d*(?:e[\-+]?\d+)?)[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*/gi,kb=(c._radial_gradient=/^r(?:\(([^,]+?)[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*([^\)]+?)\))?/,{}),lb=function(a,b){return _(a)-_(b)},mb=function(){},nb=function(a){return a},ob=c._rectPath=function(a,b,c,d,e){return e?[["M",a+e,b],["l",c-2*e,0],["a",e,e,0,0,1,e,e],["l",0,d-2*e],["a",e,e,0,0,1,-e,e],["l",2*e-c,0],["a",e,e,0,0,1,-e,-e],["l",0,2*e-d],["a",e,e,0,0,1,e,-e],["z"]]:[["M",a,b],["l",c,0],["l",0,d],["l",-c,0],["z"]]},pb=function(a,b,c,d){return null==d&&(d=c),[["M",a,b],["m",0,-d],["a",c,d,0,1,1,0,2*d],["a",c,d,0,1,1,0,-2*d],["z"]]},qb=c._getPath={path:function(a){return a.attr("path")},circle:function(a){var b=a.attrs;return pb(b.cx,b.cy,b.r)},ellipse:function(a){var b=a.attrs;return pb(b.cx,b.cy,b.rx,b.ry)},rect:function(a){var b=a.attrs;return ob(b.x,b.y,b.width,b.height,b.r)},image:function(a){var b=a.attrs;return ob(b.x,b.y,b.width,b.height)},text:function(a){var b=a._getBBox();return ob(b.x,b.y,b.width,b.height)},set:function(a){var b=a._getBBox();return ob(b.x,b.y,b.width,b.height)}},rb=c.mapPath=function(a,b){if(!b)return a;var c,d,e,f,g,h,i;for(a=Kb(a),e=0,g=a.length;g>e;e++)for(i=a[e],f=1,h=i.length;h>f;f+=2)c=b.x(i[f],i[f+1]),d=b.y(i[f],i[f+1]),i[f]=c,i[f+1]=d;return a};if(c._g=A,c.type=A.win.SVGAngle||A.doc.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure","1.1")?"SVG":"VML","VML"==c.type){var sb,tb=A.doc.createElement("div");if(tb.innerHTML='<v:shape adj="1"/>',sb=tb.firstChild,sb.style.behavior="url(#default#VML)",!sb||"object"!=typeof sb.adj)return c.type=G;tb=null}c.svg=!(c.vml="VML"==c.type),c._Paper=C,c.fn=v=C.prototype=c.prototype,c._id=0,c._oid=0,c.is=function(a,b){return b=M.call(b),"finite"==b?!Y[z](+a):"array"==b?a instanceof Array:"null"==b&&null===a||b==typeof a&&null!==a||"object"==b&&a===Object(a)||"array"==b&&Array.isArray&&Array.isArray(a)||W.call(a).slice(8,-1).toLowerCase()==b},c.angle=function(a,b,d,e,f,g){if(null==f){var h=a-d,i=b-e;return h||i?(180+180*N.atan2(-i,-h)/S+360)%360:0}return c.angle(a,b,f,g)-c.angle(d,e,f,g)},c.rad=function(a){return a%360*S/180},c.deg=function(a){return Math.round(180*a/S%360*1e3)/1e3},c.snapTo=function(a,b,d){if(d=c.is(d,"finite")?d:10,c.is(a,V)){for(var e=a.length;e--;)if(Q(a[e]-b)<=d)return a[e]}else{a=+a;var f=b%a;if(d>f)return b-f;if(f>a-d)return b-f+a}return b};c.createUUID=function(a,b){return function(){return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(a,b).toUpperCase()}}(/[xy]/g,function(a){var b=16*N.random()|0,c="x"==a?b:3&b|8;return c.toString(16)});c.setWindow=function(a){b("raphael.setWindow",c,A.win,a),A.win=a,A.doc=A.win.document,c._engine.initWin&&c._engine.initWin(A.win)};var ub=function(a){if(c.vml){var b,d=/^\s+|\s+$/g;try{var e=new ActiveXObject("htmlfile");e.write("<body>"),e.close(),b=e.body}catch(g){b=createPopup().document.body}var h=b.createTextRange();ub=f(function(a){try{b.style.color=I(a).replace(d,G);var c=h.queryCommandValue("ForeColor");return c=(255&c)<<16|65280&c|(16711680&c)>>>16,"#"+("000000"+c.toString(16)).slice(-6)}catch(e){return"none"}})}else{var i=A.doc.createElement("i");i.title="RaphaÃ«l Colour Picker",i.style.display="none",A.doc.body.appendChild(i),ub=f(function(a){return i.style.color=a,A.doc.defaultView.getComputedStyle(i,G).getPropertyValue("color")})}return ub(a)},vb=function(){return"hsb("+[this.h,this.s,this.b]+")"},wb=function(){return"hsl("+[this.h,this.s,this.l]+")"},xb=function(){return this.hex},yb=function(a,b,d){if(null==b&&c.is(a,"object")&&"r"in a&&"g"in a&&"b"in a&&(d=a.b,b=a.g,a=a.r),null==b&&c.is(a,U)){var e=c.getRGB(a);a=e.r,b=e.g,d=e.b}return(a>1||b>1||d>1)&&(a/=255,b/=255,d/=255),[a,b,d]},zb=function(a,b,d,e){a*=255,b*=255,d*=255;var f={r:a,g:b,b:d,hex:c.rgb(a,b,d),toString:xb};return c.is(e,"finite")&&(f.opacity=e),f};c.color=function(a){var b;return c.is(a,"object")&&"h"in a&&"s"in a&&"b"in a?(b=c.hsb2rgb(a),a.r=b.r,a.g=b.g,a.b=b.b,a.hex=b.hex):c.is(a,"object")&&"h"in a&&"s"in a&&"l"in a?(b=c.hsl2rgb(a),a.r=b.r,a.g=b.g,a.b=b.b,a.hex=b.hex):(c.is(a,"string")&&(a=c.getRGB(a)),c.is(a,"object")&&"r"in a&&"g"in a&&"b"in a?(b=c.rgb2hsl(a),a.h=b.h,a.s=b.s,a.l=b.l,b=c.rgb2hsb(a),a.v=b.b):(a={hex:"none"},a.r=a.g=a.b=a.h=a.s=a.v=a.l=-1)),a.toString=xb,a},c.hsb2rgb=function(a,b,c,d){this.is(a,"object")&&"h"in a&&"s"in a&&"b"in a&&(c=a.b,b=a.s,d=a.o,a=a.h),a*=360;var e,f,g,h,i;return a=a%360/60,i=c*b,h=i*(1-Q(a%2-1)),e=f=g=c-i,a=~~a,e+=[i,h,0,0,h,i][a],f+=[h,i,i,h,0,0][a],g+=[0,0,h,i,i,h][a],zb(e,f,g,d)},c.hsl2rgb=function(a,b,c,d){this.is(a,"object")&&"h"in a&&"s"in a&&"l"in a&&(c=a.l,b=a.s,a=a.h),(a>1||b>1||c>1)&&(a/=360,b/=100,c/=100),a*=360;var e,f,g,h,i;return a=a%360/60,i=2*b*(.5>c?c:1-c),h=i*(1-Q(a%2-1)),e=f=g=c-i/2,a=~~a,e+=[i,h,0,0,h,i][a],f+=[h,i,i,h,0,0][a],g+=[0,0,h,i,i,h][a],zb(e,f,g,d)},c.rgb2hsb=function(a,b,c){c=yb(a,b,c),a=c[0],b=c[1],c=c[2];var d,e,f,g;return f=O(a,b,c),g=f-P(a,b,c),d=0==g?null:f==a?(b-c)/g:f==b?(c-a)/g+2:(a-b)/g+4,d=(d+360)%6*60/360,e=0==g?0:g/f,{h:d,s:e,b:f,toString:vb}},c.rgb2hsl=function(a,b,c){c=yb(a,b,c),a=c[0],b=c[1],c=c[2];var d,e,f,g,h,i;return g=O(a,b,c),h=P(a,b,c),i=g-h,d=0==i?null:g==a?(b-c)/i:g==b?(c-a)/i+2:(a-b)/i+4,d=(d+360)%6*60/360,f=(g+h)/2,e=0==i?0:.5>f?i/(2*f):i/(2-2*f),{h:d,s:e,l:f,toString:wb}},c._path2string=function(){return this.join(",").replace(gb,"$1")};c._preload=function(a,b){var c=A.doc.createElement("img");c.style.cssText="position:absolute;left:-9999em;top:-9999em",c.onload=function(){b.call(this),this.onload=null,A.doc.body.removeChild(this)},c.onerror=function(){A.doc.body.removeChild(this)},A.doc.body.appendChild(c),c.src=a};c.getRGB=f(function(a){if(!a||(a=I(a)).indexOf("-")+1)return{r:-1,g:-1,b:-1,hex:"none",error:1,toString:g};if("none"==a)return{r:-1,g:-1,b:-1,hex:"none",toString:g};!(fb[z](a.toLowerCase().substring(0,2))||"#"==a.charAt())&&(a=ub(a));var b,d,e,f,h,i,j=a.match(X);return j?(j[2]&&(e=ab(j[2].substring(5),16),d=ab(j[2].substring(3,5),16),b=ab(j[2].substring(1,3),16)),j[3]&&(e=ab((h=j[3].charAt(3))+h,16),d=ab((h=j[3].charAt(2))+h,16),b=ab((h=j[3].charAt(1))+h,16)),j[4]&&(i=j[4][J](eb),b=_(i[0]),"%"==i[0].slice(-1)&&(b*=2.55),d=_(i[1]),"%"==i[1].slice(-1)&&(d*=2.55),e=_(i[2]),"%"==i[2].slice(-1)&&(e*=2.55),"rgba"==j[1].toLowerCase().slice(0,4)&&(f=_(i[3])),i[3]&&"%"==i[3].slice(-1)&&(f/=100)),j[5]?(i=j[5][J](eb),b=_(i[0]),"%"==i[0].slice(-1)&&(b*=2.55),d=_(i[1]),"%"==i[1].slice(-1)&&(d*=2.55),e=_(i[2]),"%"==i[2].slice(-1)&&(e*=2.55),("deg"==i[0].slice(-3)||"Â°"==i[0].slice(-1))&&(b/=360),"hsba"==j[1].toLowerCase().slice(0,4)&&(f=_(i[3])),i[3]&&"%"==i[3].slice(-1)&&(f/=100),c.hsb2rgb(b,d,e,f)):j[6]?(i=j[6][J](eb),b=_(i[0]),"%"==i[0].slice(-1)&&(b*=2.55),d=_(i[1]),"%"==i[1].slice(-1)&&(d*=2.55),e=_(i[2]),"%"==i[2].slice(-1)&&(e*=2.55),("deg"==i[0].slice(-3)||"Â°"==i[0].slice(-1))&&(b/=360),"hsla"==j[1].toLowerCase().slice(0,4)&&(f=_(i[3])),i[3]&&"%"==i[3].slice(-1)&&(f/=100),c.hsl2rgb(b,d,e,f)):(j={r:b,g:d,b:e,toString:g},j.hex="#"+(16777216|e|d<<8|b<<16).toString(16).slice(1),c.is(f,"finite")&&(j.opacity=f),j)):{r:-1,g:-1,b:-1,hex:"none",error:1,toString:g}},c),c.hsb=f(function(a,b,d){return c.hsb2rgb(a,b,d).hex}),c.hsl=f(function(a,b,d){return c.hsl2rgb(a,b,d).hex}),c.rgb=f(function(a,b,c){return"#"+(16777216|c|b<<8|a<<16).toString(16).slice(1)}),c.getColor=function(a){var b=this.getColor.start=this.getColor.start||{h:0,s:1,b:a||.75},c=this.hsb2rgb(b.h,b.s,b.b);return b.h+=.075,b.h>1&&(b.h=0,b.s-=.2,b.s<=0&&(this.getColor.start={h:0,s:1,b:b.b})),c.hex},c.getColor.reset=function(){delete this.start},c.parsePathString=function(a){if(!a)return null;var b=Ab(a);if(b.arr)return Cb(b.arr);var d={a:7,c:6,h:1,l:2,m:2,r:4,q:4,s:4,t:2,v:1,z:0},e=[];return c.is(a,V)&&c.is(a[0],V)&&(e=Cb(a)),e.length||I(a).replace(hb,function(a,b,c){var f=[],g=b.toLowerCase();if(c.replace(jb,function(a,b){b&&f.push(+b)}),"m"==g&&f.length>2&&(e.push([b][E](f.splice(0,2))),g="l",b="m"==b?"l":"L"),"r"==g)e.push([b][E](f));else for(;f.length>=d[g]&&(e.push([b][E](f.splice(0,d[g]))),d[g]););}),e.toString=c._path2string,b.arr=Cb(e),e},c.parseTransformString=f(function(a){if(!a)return null;var b=[];return c.is(a,V)&&c.is(a[0],V)&&(b=Cb(a)),b.length||I(a).replace(ib,function(a,c,d){{var e=[];M.call(c)}d.replace(jb,function(a,b){b&&e.push(+b)}),b.push([c][E](e))}),b.toString=c._path2string,b});var Ab=function(a){var b=Ab.ps=Ab.ps||{};return b[a]?b[a].sleep=100:b[a]={sleep:100},setTimeout(function(){for(var c in b)b[z](c)&&c!=a&&(b[c].sleep--,!b[c].sleep&&delete b[c])}),b[a]};c.findDotsAtSegment=function(a,b,c,d,e,f,g,h,i){var j=1-i,k=R(j,3),l=R(j,2),m=i*i,n=m*i,o=k*a+3*l*i*c+3*j*i*i*e+n*g,p=k*b+3*l*i*d+3*j*i*i*f+n*h,q=a+2*i*(c-a)+m*(e-2*c+a),r=b+2*i*(d-b)+m*(f-2*d+b),s=c+2*i*(e-c)+m*(g-2*e+c),t=d+2*i*(f-d)+m*(h-2*f+d),u=j*a+i*c,v=j*b+i*d,w=j*e+i*g,x=j*f+i*h,y=90-180*N.atan2(q-s,r-t)/S;return(q>s||t>r)&&(y+=180),{x:o,y:p,m:{x:q,y:r},n:{x:s,y:t},start:{x:u,y:v},end:{x:w,y:x},alpha:y}},c.bezierBBox=function(a,b,d,e,f,g,h,i){c.is(a,"array")||(a=[a,b,d,e,f,g,h,i]);var j=Jb.apply(null,a);return{x:j.min.x,y:j.min.y,x2:j.max.x,y2:j.max.y,width:j.max.x-j.min.x,height:j.max.y-j.min.y}},c.isPointInsideBBox=function(a,b,c){return b>=a.x&&b<=a.x2&&c>=a.y&&c<=a.y2},c.isBBoxIntersect=function(a,b){var d=c.isPointInsideBBox;return d(b,a.x,a.y)||d(b,a.x2,a.y)||d(b,a.x,a.y2)||d(b,a.x2,a.y2)||d(a,b.x,b.y)||d(a,b.x2,b.y)||d(a,b.x,b.y2)||d(a,b.x2,b.y2)||(a.x<b.x2&&a.x>b.x||b.x<a.x2&&b.x>a.x)&&(a.y<b.y2&&a.y>b.y||b.y<a.y2&&b.y>a.y)},c.pathIntersection=function(a,b){return n(a,b)},c.pathIntersectionNumber=function(a,b){return n(a,b,1)},c.isPointInsidePath=function(a,b,d){var e=c.pathBBox(a);return c.isPointInsideBBox(e,b,d)&&n(a,[["M",b,d],["H",e.x2+10]],1)%2==1},c._removedFactory=function(a){return function(){b("raphael.log",null,"RaphaÃ«l: you are calling to method â€œ"+a+"â€ of removed object",a)}};var Bb=c.pathBBox=function(a){var b=Ab(a);if(b.bbox)return d(b.bbox);if(!a)return{x:0,y:0,width:0,height:0,x2:0,y2:0};a=Kb(a);for(var c,e=0,f=0,g=[],h=[],i=0,j=a.length;j>i;i++)if(c=a[i],"M"==c[0])e=c[1],f=c[2],g.push(e),h.push(f);else{var k=Jb(e,f,c[1],c[2],c[3],c[4],c[5],c[6]);g=g[E](k.min.x,k.max.x),h=h[E](k.min.y,k.max.y),e=c[5],f=c[6]}var l=P[D](0,g),m=P[D](0,h),n=O[D](0,g),o=O[D](0,h),p=n-l,q=o-m,r={x:l,y:m,x2:n,y2:o,width:p,height:q,cx:l+p/2,cy:m+q/2};return b.bbox=d(r),r},Cb=function(a){var b=d(a);return b.toString=c._path2string,b},Db=c._pathToRelative=function(a){var b=Ab(a);if(b.rel)return Cb(b.rel);c.is(a,V)&&c.is(a&&a[0],V)||(a=c.parsePathString(a));var d=[],e=0,f=0,g=0,h=0,i=0;"M"==a[0][0]&&(e=a[0][1],f=a[0][2],g=e,h=f,i++,d.push(["M",e,f]));for(var j=i,k=a.length;k>j;j++){var l=d[j]=[],m=a[j];if(m[0]!=M.call(m[0]))switch(l[0]=M.call(m[0]),l[0]){case"a":l[1]=m[1],l[2]=m[2],l[3]=m[3],l[4]=m[4],l[5]=m[5],l[6]=+(m[6]-e).toFixed(3),l[7]=+(m[7]-f).toFixed(3);break;case"v":l[1]=+(m[1]-f).toFixed(3);break;case"m":g=m[1],h=m[2];default:for(var n=1,o=m.length;o>n;n++)l[n]=+(m[n]-(n%2?e:f)).toFixed(3)}else{l=d[j]=[],"m"==m[0]&&(g=m[1]+e,h=m[2]+f);for(var p=0,q=m.length;q>p;p++)d[j][p]=m[p]}var r=d[j].length;switch(d[j][0]){case"z":e=g,f=h;break;case"h":e+=+d[j][r-1];break;case"v":f+=+d[j][r-1];break;default:e+=+d[j][r-2],f+=+d[j][r-1]}}return d.toString=c._path2string,b.rel=Cb(d),d},Eb=c._pathToAbsolute=function(a){var b=Ab(a);if(b.abs)return Cb(b.abs);if(c.is(a,V)&&c.is(a&&a[0],V)||(a=c.parsePathString(a)),!a||!a.length)return[["M",0,0]];var d=[],e=0,f=0,g=0,i=0,j=0;"M"==a[0][0]&&(e=+a[0][1],f=+a[0][2],g=e,i=f,j++,d[0]=["M",e,f]);for(var k,l,m=3==a.length&&"M"==a[0][0]&&"R"==a[1][0].toUpperCase()&&"Z"==a[2][0].toUpperCase(),n=j,o=a.length;o>n;n++){if(d.push(k=[]),l=a[n],l[0]!=bb.call(l[0]))switch(k[0]=bb.call(l[0]),k[0]){case"A":k[1]=l[1],k[2]=l[2],k[3]=l[3],k[4]=l[4],k[5]=l[5],k[6]=+(l[6]+e),k[7]=+(l[7]+f);break;case"V":k[1]=+l[1]+f;break;case"H":k[1]=+l[1]+e;break;case"R":for(var p=[e,f][E](l.slice(1)),q=2,r=p.length;r>q;q++)p[q]=+p[q]+e,p[++q]=+p[q]+f;d.pop(),d=d[E](h(p,m));break;case"M":g=+l[1]+e,i=+l[2]+f;default:for(q=1,r=l.length;r>q;q++)k[q]=+l[q]+(q%2?e:f)}else if("R"==l[0])p=[e,f][E](l.slice(1)),d.pop(),d=d[E](h(p,m)),k=["R"][E](l.slice(-2));else for(var s=0,t=l.length;t>s;s++)k[s]=l[s];switch(k[0]){case"Z":e=g,f=i;break;case"H":e=k[1];break;case"V":f=k[1];break;case"M":g=k[k.length-2],i=k[k.length-1];default:e=k[k.length-2],f=k[k.length-1]}}return d.toString=c._path2string,b.abs=Cb(d),d},Fb=function(a,b,c,d){return[a,b,c,d,c,d]},Gb=function(a,b,c,d,e,f){var g=1/3,h=2/3;return[g*a+h*c,g*b+h*d,g*e+h*c,g*f+h*d,e,f]},Hb=function(a,b,c,d,e,g,h,i,j,k){var l,m=120*S/180,n=S/180*(+e||0),o=[],p=f(function(a,b,c){var d=a*N.cos(c)-b*N.sin(c),e=a*N.sin(c)+b*N.cos(c);return{x:d,y:e}});if(k)y=k[0],z=k[1],w=k[2],x=k[3];else{l=p(a,b,-n),a=l.x,b=l.y,l=p(i,j,-n),i=l.x,j=l.y;var q=(N.cos(S/180*e),N.sin(S/180*e),(a-i)/2),r=(b-j)/2,s=q*q/(c*c)+r*r/(d*d);s>1&&(s=N.sqrt(s),c=s*c,d=s*d);var t=c*c,u=d*d,v=(g==h?-1:1)*N.sqrt(Q((t*u-t*r*r-u*q*q)/(t*r*r+u*q*q))),w=v*c*r/d+(a+i)/2,x=v*-d*q/c+(b+j)/2,y=N.asin(((b-x)/d).toFixed(9)),z=N.asin(((j-x)/d).toFixed(9));y=w>a?S-y:y,z=w>i?S-z:z,0>y&&(y=2*S+y),0>z&&(z=2*S+z),h&&y>z&&(y-=2*S),!h&&z>y&&(z-=2*S)}var A=z-y;if(Q(A)>m){var B=z,C=i,D=j;z=y+m*(h&&z>y?1:-1),i=w+c*N.cos(z),j=x+d*N.sin(z),o=Hb(i,j,c,d,e,0,h,C,D,[z,B,w,x])}A=z-y;var F=N.cos(y),G=N.sin(y),H=N.cos(z),I=N.sin(z),K=N.tan(A/4),L=4/3*c*K,M=4/3*d*K,O=[a,b],P=[a+L*G,b-M*F],R=[i+L*I,j-M*H],T=[i,j];if(P[0]=2*O[0]-P[0],P[1]=2*O[1]-P[1],k)return[P,R,T][E](o);o=[P,R,T][E](o).join()[J](",");for(var U=[],V=0,W=o.length;W>V;V++)U[V]=V%2?p(o[V-1],o[V],n).y:p(o[V],o[V+1],n).x;return U},Ib=function(a,b,c,d,e,f,g,h,i){var j=1-i;return{x:R(j,3)*a+3*R(j,2)*i*c+3*j*i*i*e+R(i,3)*g,y:R(j,3)*b+3*R(j,2)*i*d+3*j*i*i*f+R(i,3)*h}},Jb=f(function(a,b,c,d,e,f,g,h){var i,j=e-2*c+a-(g-2*e+c),k=2*(c-a)-2*(e-c),l=a-c,m=(-k+N.sqrt(k*k-4*j*l))/2/j,n=(-k-N.sqrt(k*k-4*j*l))/2/j,o=[b,h],p=[a,g];return Q(m)>"1e12"&&(m=.5),Q(n)>"1e12"&&(n=.5),m>0&&1>m&&(i=Ib(a,b,c,d,e,f,g,h,m),p.push(i.x),o.push(i.y)),n>0&&1>n&&(i=Ib(a,b,c,d,e,f,g,h,n),p.push(i.x),o.push(i.y)),j=f-2*d+b-(h-2*f+d),k=2*(d-b)-2*(f-d),l=b-d,m=(-k+N.sqrt(k*k-4*j*l))/2/j,n=(-k-N.sqrt(k*k-4*j*l))/2/j,Q(m)>"1e12"&&(m=.5),Q(n)>"1e12"&&(n=.5),m>0&&1>m&&(i=Ib(a,b,c,d,e,f,g,h,m),p.push(i.x),o.push(i.y)),n>0&&1>n&&(i=Ib(a,b,c,d,e,f,g,h,n),p.push(i.x),o.push(i.y)),{min:{x:P[D](0,p),y:P[D](0,o)},max:{x:O[D](0,p),y:O[D](0,o)}}}),Kb=c._path2curve=f(function(a,b){var c=!b&&Ab(a);if(!b&&c.curve)return Cb(c.curve);for(var d=Eb(a),e=b&&Eb(b),f={x:0,y:0,bx:0,by:0,X:0,Y:0,qx:null,qy:null},g={x:0,y:0,bx:0,by:0,X:0,Y:0,qx:null,qy:null},h=(function(a,b,c){var d,e,f={T:1,Q:1};if(!a)return["C",b.x,b.y,b.x,b.y,b.x,b.y];switch(!(a[0]in f)&&(b.qx=b.qy=null),a[0]){case"M":b.X=a[1],b.Y=a[2];break;case"A":a=["C"][E](Hb[D](0,[b.x,b.y][E](a.slice(1))));break;case"S":"C"==c||"S"==c?(d=2*b.x-b.bx,e=2*b.y-b.by):(d=b.x,e=b.y),a=["C",d,e][E](a.slice(1));break;case"T":"Q"==c||"T"==c?(b.qx=2*b.x-b.qx,b.qy=2*b.y-b.qy):(b.qx=b.x,b.qy=b.y),a=["C"][E](Gb(b.x,b.y,b.qx,b.qy,a[1],a[2]));break;case"Q":b.qx=a[1],b.qy=a[2],a=["C"][E](Gb(b.x,b.y,a[1],a[2],a[3],a[4]));break;case"L":a=["C"][E](Fb(b.x,b.y,a[1],a[2]));break;case"H":a=["C"][E](Fb(b.x,b.y,a[1],b.y));break;case"V":a=["C"][E](Fb(b.x,b.y,b.x,a[1]));break;case"Z":a=["C"][E](Fb(b.x,b.y,b.X,b.Y))}return a}),i=function(a,b){if(a[b].length>7){a[b].shift();for(var c=a[b];c.length;)k[b]="A",e&&(l[b]="A"),a.splice(b++,0,["C"][E](c.splice(0,6)));a.splice(b,1),p=O(d.length,e&&e.length||0)}},j=function(a,b,c,f,g){a&&b&&"M"==a[g][0]&&"M"!=b[g][0]&&(b.splice(g,0,["M",f.x,f.y]),c.bx=0,c.by=0,c.x=a[g][1],c.y=a[g][2],p=O(d.length,e&&e.length||0))},k=[],l=[],m="",n="",o=0,p=O(d.length,e&&e.length||0);p>o;o++){d[o]&&(m=d[o][0]),"C"!=m&&(k[o]=m,o&&(n=k[o-1])),d[o]=h(d[o],f,n),"A"!=k[o]&&"C"==m&&(k[o]="C"),i(d,o),e&&(e[o]&&(m=e[o][0]),"C"!=m&&(l[o]=m,o&&(n=l[o-1])),e[o]=h(e[o],g,n),"A"!=l[o]&&"C"==m&&(l[o]="C"),i(e,o)),j(d,e,f,g,o),j(e,d,g,f,o);var q=d[o],r=e&&e[o],s=q.length,t=e&&r.length;f.x=q[s-2],f.y=q[s-1],f.bx=_(q[s-4])||f.x,f.by=_(q[s-3])||f.y,g.bx=e&&(_(r[t-4])||g.x),g.by=e&&(_(r[t-3])||g.y),g.x=e&&r[t-2],g.y=e&&r[t-1]}return e||(c.curve=Cb(d)),e?[d,e]:d},null,Cb),Lb=(c._parseDots=f(function(a){for(var b=[],d=0,e=a.length;e>d;d++){var f={},g=a[d].match(/^([^:]*):?([\d\.]*)/);if(f.color=c.getRGB(g[1]),f.color.error)return null;f.color=f.color.hex,g[2]&&(f.offset=g[2]+"%"),b.push(f)}for(d=1,e=b.length-1;e>d;d++)if(!b[d].offset){for(var h=_(b[d-1].offset||0),i=0,j=d+1;e>j;j++)if(b[j].offset){i=b[j].offset;break}i||(i=100,j=e),i=_(i);for(var k=(i-h)/(j-d+1);j>d;d++)h+=k,b[d].offset=h+"%"}return b}),c._tear=function(a,b){a==b.top&&(b.top=a.prev),a==b.bottom&&(b.bottom=a.next),a.next&&(a.next.prev=a.prev),a.prev&&(a.prev.next=a.next)}),Mb=(c._tofront=function(a,b){b.top!==a&&(Lb(a,b),a.next=null,a.prev=b.top,b.top.next=a,b.top=a)},c._toback=function(a,b){b.bottom!==a&&(Lb(a,b),a.next=b.bottom,a.prev=null,b.bottom.prev=a,b.bottom=a)},c._insertafter=function(a,b,c){Lb(a,c),b==c.top&&(c.top=a),b.next&&(b.next.prev=a),a.next=b.next,a.prev=b,b.next=a},c._insertbefore=function(a,b,c){Lb(a,c),b==c.bottom&&(c.bottom=a),b.prev&&(b.prev.next=a),a.prev=b.prev,b.prev=a,a.next=b},c.toMatrix=function(a,b){var c=Bb(a),d={_:{transform:G},getBBox:function(){return c}};return Nb(d,b),d.matrix}),Nb=(c.transformPath=function(a,b){return rb(a,Mb(a,b))},c._extractTransform=function(a,b){if(null==b)return a._.transform;b=I(b).replace(/\.{3}|\u2026/g,a._.transform||G);var d=c.parseTransformString(b),e=0,f=0,g=0,h=1,i=1,j=a._,k=new o;if(j.transform=d||[],d)for(var l=0,m=d.length;m>l;l++){var n,p,q,r,s,t=d[l],u=t.length,v=I(t[0]).toLowerCase(),w=t[0]!=v,x=w?k.invert():0;"t"==v&&3==u?w?(n=x.x(0,0),p=x.y(0,0),q=x.x(t[1],t[2]),r=x.y(t[1],t[2]),k.translate(q-n,r-p)):k.translate(t[1],t[2]):"r"==v?2==u?(s=s||a.getBBox(1),k.rotate(t[1],s.x+s.width/2,s.y+s.height/2),e+=t[1]):4==u&&(w?(q=x.x(t[2],t[3]),r=x.y(t[2],t[3]),k.rotate(t[1],q,r)):k.rotate(t[1],t[2],t[3]),e+=t[1]):"s"==v?2==u||3==u?(s=s||a.getBBox(1),k.scale(t[1],t[u-1],s.x+s.width/2,s.y+s.height/2),h*=t[1],i*=t[u-1]):5==u&&(w?(q=x.x(t[3],t[4]),r=x.y(t[3],t[4]),k.scale(t[1],t[2],q,r)):k.scale(t[1],t[2],t[3],t[4]),h*=t[1],i*=t[2]):"m"==v&&7==u&&k.add(t[1],t[2],t[3],t[4],t[5],t[6]),j.dirtyT=1,a.matrix=k}a.matrix=k,j.sx=h,j.sy=i,j.deg=e,j.dx=f=k.e,j.dy=g=k.f,1==h&&1==i&&!e&&j.bbox?(j.bbox.x+=+f,j.bbox.y+=+g):j.dirtyT=1}),Ob=function(a){var b=a[0];switch(b.toLowerCase()){case"t":return[b,0,0];case"m":return[b,1,0,0,1,0,0];case"r":return 4==a.length?[b,0,a[2],a[3]]:[b,0];case"s":return 5==a.length?[b,1,1,a[3],a[4]]:3==a.length?[b,1,1]:[b,1]}},Pb=c._equaliseTransform=function(a,b){b=I(b).replace(/\.{3}|\u2026/g,a),a=c.parseTransformString(a)||[],b=c.parseTransformString(b)||[];
    for(var d,e,f,g,h=O(a.length,b.length),i=[],j=[],k=0;h>k;k++){if(f=a[k]||Ob(b[k]),g=b[k]||Ob(f),f[0]!=g[0]||"r"==f[0].toLowerCase()&&(f[2]!=g[2]||f[3]!=g[3])||"s"==f[0].toLowerCase()&&(f[3]!=g[3]||f[4]!=g[4]))return;for(i[k]=[],j[k]=[],d=0,e=O(f.length,g.length);e>d;d++)d in f&&(i[k][d]=f[d]),d in g&&(j[k][d]=g[d])}return{from:i,to:j}};c._getContainer=function(a,b,d,e){var f;return f=null!=e||c.is(a,"object")?a:A.doc.getElementById(a),null!=f?f.tagName?null==b?{container:f,width:f.style.pixelWidth||f.offsetWidth,height:f.style.pixelHeight||f.offsetHeight}:{container:f,width:b,height:d}:{container:1,x:a,y:b,width:d,height:e}:void 0},c.pathToRelative=Db,c._engine={},c.path2curve=Kb,c.matrix=function(a,b,c,d,e,f){return new o(a,b,c,d,e,f)},function(a){function b(a){return a[0]*a[0]+a[1]*a[1]}function d(a){var c=N.sqrt(b(a));a[0]&&(a[0]/=c),a[1]&&(a[1]/=c)}a.add=function(a,b,c,d,e,f){var g,h,i,j,k=[[],[],[]],l=[[this.a,this.c,this.e],[this.b,this.d,this.f],[0,0,1]],m=[[a,c,e],[b,d,f],[0,0,1]];for(a&&a instanceof o&&(m=[[a.a,a.c,a.e],[a.b,a.d,a.f],[0,0,1]]),g=0;3>g;g++)for(h=0;3>h;h++){for(j=0,i=0;3>i;i++)j+=l[g][i]*m[i][h];k[g][h]=j}this.a=k[0][0],this.b=k[1][0],this.c=k[0][1],this.d=k[1][1],this.e=k[0][2],this.f=k[1][2]},a.invert=function(){var a=this,b=a.a*a.d-a.b*a.c;return new o(a.d/b,-a.b/b,-a.c/b,a.a/b,(a.c*a.f-a.d*a.e)/b,(a.b*a.e-a.a*a.f)/b)},a.clone=function(){return new o(this.a,this.b,this.c,this.d,this.e,this.f)},a.translate=function(a,b){this.add(1,0,0,1,a,b)},a.scale=function(a,b,c,d){null==b&&(b=a),(c||d)&&this.add(1,0,0,1,c,d),this.add(a,0,0,b,0,0),(c||d)&&this.add(1,0,0,1,-c,-d)},a.rotate=function(a,b,d){a=c.rad(a),b=b||0,d=d||0;var e=+N.cos(a).toFixed(9),f=+N.sin(a).toFixed(9);this.add(e,f,-f,e,b,d),this.add(1,0,0,1,-b,-d)},a.x=function(a,b){return a*this.a+b*this.c+this.e},a.y=function(a,b){return a*this.b+b*this.d+this.f},a.get=function(a){return+this[I.fromCharCode(97+a)].toFixed(4)},a.toString=function(){return c.svg?"matrix("+[this.get(0),this.get(1),this.get(2),this.get(3),this.get(4),this.get(5)].join()+")":[this.get(0),this.get(2),this.get(1),this.get(3),0,0].join()},a.toFilter=function(){return"progid:DXImageTransform.Microsoft.Matrix(M11="+this.get(0)+", M12="+this.get(2)+", M21="+this.get(1)+", M22="+this.get(3)+", Dx="+this.get(4)+", Dy="+this.get(5)+", sizingmethod='auto expand')"},a.offset=function(){return[this.e.toFixed(4),this.f.toFixed(4)]},a.split=function(){var a={};a.dx=this.e,a.dy=this.f;var e=[[this.a,this.c],[this.b,this.d]];a.scalex=N.sqrt(b(e[0])),d(e[0]),a.shear=e[0][0]*e[1][0]+e[0][1]*e[1][1],e[1]=[e[1][0]-e[0][0]*a.shear,e[1][1]-e[0][1]*a.shear],a.scaley=N.sqrt(b(e[1])),d(e[1]),a.shear/=a.scaley;var f=-e[0][1],g=e[1][1];return 0>g?(a.rotate=c.deg(N.acos(g)),0>f&&(a.rotate=360-a.rotate)):a.rotate=c.deg(N.asin(f)),a.isSimple=!(+a.shear.toFixed(9)||a.scalex.toFixed(9)!=a.scaley.toFixed(9)&&a.rotate),a.isSuperSimple=!+a.shear.toFixed(9)&&a.scalex.toFixed(9)==a.scaley.toFixed(9)&&!a.rotate,a.noRotation=!+a.shear.toFixed(9)&&!a.rotate,a},a.toTransformString=function(a){var b=a||this[J]();return b.isSimple?(b.scalex=+b.scalex.toFixed(4),b.scaley=+b.scaley.toFixed(4),b.rotate=+b.rotate.toFixed(4),(b.dx||b.dy?"t"+[b.dx,b.dy]:G)+(1!=b.scalex||1!=b.scaley?"s"+[b.scalex,b.scaley,0,0]:G)+(b.rotate?"r"+[b.rotate,0,0]:G)):"m"+[this.get(0),this.get(1),this.get(2),this.get(3),this.get(4),this.get(5)]}}(o.prototype);var Qb=navigator.userAgent.match(/Version\/(.*?)\s/)||navigator.userAgent.match(/Chrome\/(\d+)/);v.safari="Apple Computer, Inc."==navigator.vendor&&(Qb&&Qb[1]<4||"iP"==navigator.platform.slice(0,2))||"Google Inc."==navigator.vendor&&Qb&&Qb[1]<8?function(){var a=this.rect(-99,-99,this.width+99,this.height+99).attr({stroke:"none"});setTimeout(function(){a.remove()})}:mb;for(var Rb=function(){this.returnValue=!1},Sb=function(){return this.originalEvent.preventDefault()},Tb=function(){this.cancelBubble=!0},Ub=function(){return this.originalEvent.stopPropagation()},Vb=function(a){var b=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,c=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft;return{x:a.clientX+c,y:a.clientY+b}},Wb=function(){return A.doc.addEventListener?function(a,b,c,d){var e=function(a){var b=Vb(a);return c.call(d,a,b.x,b.y)};if(a.addEventListener(b,e,!1),F&&L[b]){var f=function(b){for(var e=Vb(b),f=b,g=0,h=b.targetTouches&&b.targetTouches.length;h>g;g++)if(b.targetTouches[g].target==a){b=b.targetTouches[g],b.originalEvent=f,b.preventDefault=Sb,b.stopPropagation=Ub;break}return c.call(d,b,e.x,e.y)};a.addEventListener(L[b],f,!1)}return function(){return a.removeEventListener(b,e,!1),F&&L[b]&&a.removeEventListener(L[b],f,!1),!0}}:A.doc.attachEvent?function(a,b,c,d){var e=function(a){a=a||A.win.event;var b=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,e=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft,f=a.clientX+e,g=a.clientY+b;return a.preventDefault=a.preventDefault||Rb,a.stopPropagation=a.stopPropagation||Tb,c.call(d,a,f,g)};a.attachEvent("on"+b,e);var f=function(){return a.detachEvent("on"+b,e),!0};return f}:void 0}(),Xb=[],Yb=function(a){for(var c,d=a.clientX,e=a.clientY,f=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,g=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft,h=Xb.length;h--;){if(c=Xb[h],F&&a.touches){for(var i,j=a.touches.length;j--;)if(i=a.touches[j],i.identifier==c.el._drag.id){d=i.clientX,e=i.clientY,(a.originalEvent?a.originalEvent:a).preventDefault();break}}else a.preventDefault();var k,l=c.el.node,m=l.nextSibling,n=l.parentNode,o=l.style.display;A.win.opera&&n.removeChild(l),l.style.display="none",k=c.el.paper.getElementByPoint(d,e),l.style.display=o,A.win.opera&&(m?n.insertBefore(l,m):n.appendChild(l)),k&&b("raphael.drag.over."+c.el.id,c.el,k),d+=g,e+=f,b("raphael.drag.move."+c.el.id,c.move_scope||c.el,d-c.el._drag.x,e-c.el._drag.y,d,e,a)}},Zb=function(a){c.unmousemove(Yb).unmouseup(Zb);for(var d,e=Xb.length;e--;)d=Xb[e],d.el._drag={},b("raphael.drag.end."+d.el.id,d.end_scope||d.start_scope||d.move_scope||d.el,a);Xb=[]},$b=c.el={},_b=K.length;_b--;)!function(a){c[a]=$b[a]=function(b,d){return c.is(b,"function")&&(this.events=this.events||[],this.events.push({name:a,f:b,unbind:Wb(this.shape||this.node||A.doc,a,b,d||this)})),this},c["un"+a]=$b["un"+a]=function(b){for(var d=this.events||[],e=d.length;e--;)d[e].name!=a||!c.is(b,"undefined")&&d[e].f!=b||(d[e].unbind(),d.splice(e,1),!d.length&&delete this.events);return this}}(K[_b]);$b.data=function(a,d){var e=kb[this.id]=kb[this.id]||{};if(0==arguments.length)return e;if(1==arguments.length){if(c.is(a,"object")){for(var f in a)a[z](f)&&this.data(f,a[f]);return this}return b("raphael.data.get."+this.id,this,e[a],a),e[a]}return e[a]=d,b("raphael.data.set."+this.id,this,d,a),this},$b.removeData=function(a){return null==a?kb[this.id]={}:kb[this.id]&&delete kb[this.id][a],this},$b.getData=function(){return d(kb[this.id]||{})},$b.hover=function(a,b,c,d){return this.mouseover(a,c).mouseout(b,d||c)},$b.unhover=function(a,b){return this.unmouseover(a).unmouseout(b)};var ac=[];$b.drag=function(a,d,e,f,g,h){function i(i){(i.originalEvent||i).preventDefault();var j=i.clientX,k=i.clientY,l=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,m=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft;if(this._drag.id=i.identifier,F&&i.touches)for(var n,o=i.touches.length;o--;)if(n=i.touches[o],this._drag.id=n.identifier,n.identifier==this._drag.id){j=n.clientX,k=n.clientY;break}this._drag.x=j+m,this._drag.y=k+l,!Xb.length&&c.mousemove(Yb).mouseup(Zb),Xb.push({el:this,move_scope:f,start_scope:g,end_scope:h}),d&&b.on("raphael.drag.start."+this.id,d),a&&b.on("raphael.drag.move."+this.id,a),e&&b.on("raphael.drag.end."+this.id,e),b("raphael.drag.start."+this.id,g||f||this,i.clientX+m,i.clientY+l,i)}return this._drag={},ac.push({el:this,start:i}),this.mousedown(i),this},$b.onDragOver=function(a){a?b.on("raphael.drag.over."+this.id,a):b.unbind("raphael.drag.over."+this.id)},$b.undrag=function(){for(var a=ac.length;a--;)ac[a].el==this&&(this.unmousedown(ac[a].start),ac.splice(a,1),b.unbind("raphael.drag.*."+this.id));!ac.length&&c.unmousemove(Yb).unmouseup(Zb),Xb=[]},v.circle=function(a,b,d){var e=c._engine.circle(this,a||0,b||0,d||0);return this.__set__&&this.__set__.push(e),e},v.rect=function(a,b,d,e,f){var g=c._engine.rect(this,a||0,b||0,d||0,e||0,f||0);return this.__set__&&this.__set__.push(g),g},v.ellipse=function(a,b,d,e){var f=c._engine.ellipse(this,a||0,b||0,d||0,e||0);return this.__set__&&this.__set__.push(f),f},v.path=function(a){a&&!c.is(a,U)&&!c.is(a[0],V)&&(a+=G);var b=c._engine.path(c.format[D](c,arguments),this);return this.__set__&&this.__set__.push(b),b},v.image=function(a,b,d,e,f){var g=c._engine.image(this,a||"about:blank",b||0,d||0,e||0,f||0);return this.__set__&&this.__set__.push(g),g},v.text=function(a,b,d){var e=c._engine.text(this,a||0,b||0,I(d));return this.__set__&&this.__set__.push(e),e},v.set=function(a){!c.is(a,"array")&&(a=Array.prototype.splice.call(arguments,0,arguments.length));var b=new mc(a);return this.__set__&&this.__set__.push(b),b.paper=this,b.type="set",b},v.setStart=function(a){this.__set__=a||this.set()},v.setFinish=function(){var a=this.__set__;return delete this.__set__,a},v.getSize=function(){var a=this.canvas.parentNode;return{width:a.offsetWidth,height:a.offsetHeight}},v.setSize=function(a,b){return c._engine.setSize.call(this,a,b)},v.setViewBox=function(a,b,d,e,f){return c._engine.setViewBox.call(this,a,b,d,e,f)},v.top=v.bottom=null,v.raphael=c;var bc=function(a){var b=a.getBoundingClientRect(),c=a.ownerDocument,d=c.body,e=c.documentElement,f=e.clientTop||d.clientTop||0,g=e.clientLeft||d.clientLeft||0,h=b.top+(A.win.pageYOffset||e.scrollTop||d.scrollTop)-f,i=b.left+(A.win.pageXOffset||e.scrollLeft||d.scrollLeft)-g;return{y:h,x:i}};v.getElementByPoint=function(a,b){var c=this,d=c.canvas,e=A.doc.elementFromPoint(a,b);if(A.win.opera&&"svg"==e.tagName){var f=bc(d),g=d.createSVGRect();g.x=a-f.x,g.y=b-f.y,g.width=g.height=1;var h=d.getIntersectionList(g,null);h.length&&(e=h[h.length-1])}if(!e)return null;for(;e.parentNode&&e!=d.parentNode&&!e.raphael;)e=e.parentNode;return e==c.canvas.parentNode&&(e=d),e=e&&e.raphael?c.getById(e.raphaelid):null},v.getElementsByBBox=function(a){var b=this.set();return this.forEach(function(d){c.isBBoxIntersect(d.getBBox(),a)&&b.push(d)}),b},v.getById=function(a){for(var b=this.bottom;b;){if(b.id==a)return b;b=b.next}return null},v.forEach=function(a,b){for(var c=this.bottom;c;){if(a.call(b,c)===!1)return this;c=c.next}return this},v.getElementsByPoint=function(a,b){var c=this.set();return this.forEach(function(d){d.isPointInside(a,b)&&c.push(d)}),c},$b.isPointInside=function(a,b){var d=this.realPath=qb[this.type](this);return this.attr("transform")&&this.attr("transform").length&&(d=c.transformPath(d,this.attr("transform"))),c.isPointInsidePath(d,a,b)},$b.getBBox=function(a){if(this.removed)return{};var b=this._;return a?((b.dirty||!b.bboxwt)&&(this.realPath=qb[this.type](this),b.bboxwt=Bb(this.realPath),b.bboxwt.toString=p,b.dirty=0),b.bboxwt):((b.dirty||b.dirtyT||!b.bbox)&&((b.dirty||!this.realPath)&&(b.bboxwt=0,this.realPath=qb[this.type](this)),b.bbox=Bb(rb(this.realPath,this.matrix)),b.bbox.toString=p,b.dirty=b.dirtyT=0),b.bbox)},$b.clone=function(){if(this.removed)return null;var a=this.paper[this.type]().attr(this.attr());return this.__set__&&this.__set__.push(a),a},$b.glow=function(a){if("text"==this.type)return null;a=a||{};var b={width:(a.width||10)+(+this.attr("stroke-width")||1),fill:a.fill||!1,opacity:a.opacity||.5,offsetx:a.offsetx||0,offsety:a.offsety||0,color:a.color||"#000"},c=b.width/2,d=this.paper,e=d.set(),f=this.realPath||qb[this.type](this);f=this.matrix?rb(f,this.matrix):f;for(var g=1;c+1>g;g++)e.push(d.path(f).attr({stroke:b.color,fill:b.fill?b.color:"none","stroke-linejoin":"round","stroke-linecap":"round","stroke-width":+(b.width/c*g).toFixed(3),opacity:+(b.opacity/c).toFixed(3)}));return e.insertBefore(this).translate(b.offsetx,b.offsety)};var cc=function(a,b,d,e,f,g,h,i,l){return null==l?j(a,b,d,e,f,g,h,i):c.findDotsAtSegment(a,b,d,e,f,g,h,i,k(a,b,d,e,f,g,h,i,l))},dc=function(a,b){return function(d,e,f){d=Kb(d);for(var g,h,i,j,k,l="",m={},n=0,o=0,p=d.length;p>o;o++){if(i=d[o],"M"==i[0])g=+i[1],h=+i[2];else{if(j=cc(g,h,i[1],i[2],i[3],i[4],i[5],i[6]),n+j>e){if(b&&!m.start){if(k=cc(g,h,i[1],i[2],i[3],i[4],i[5],i[6],e-n),l+=["C"+k.start.x,k.start.y,k.m.x,k.m.y,k.x,k.y],f)return l;m.start=l,l=["M"+k.x,k.y+"C"+k.n.x,k.n.y,k.end.x,k.end.y,i[5],i[6]].join(),n+=j,g=+i[5],h=+i[6];continue}if(!a&&!b)return k=cc(g,h,i[1],i[2],i[3],i[4],i[5],i[6],e-n),{x:k.x,y:k.y,alpha:k.alpha}}n+=j,g=+i[5],h=+i[6]}l+=i.shift()+i}return m.end=l,k=a?n:b?m:c.findDotsAtSegment(g,h,i[0],i[1],i[2],i[3],i[4],i[5],1),k.alpha&&(k={x:k.x,y:k.y,alpha:k.alpha}),k}},ec=dc(1),fc=dc(),gc=dc(0,1);c.getTotalLength=ec,c.getPointAtLength=fc,c.getSubpath=function(a,b,c){if(this.getTotalLength(a)-c<1e-6)return gc(a,b).end;var d=gc(a,c,1);return b?gc(d,b).end:d},$b.getTotalLength=function(){var a=this.getPath();if(a)return this.node.getTotalLength?this.node.getTotalLength():ec(a)},$b.getPointAtLength=function(a){var b=this.getPath();if(b)return fc(b,a)},$b.getPath=function(){var a,b=c._getPath[this.type];if("text"!=this.type&&"set"!=this.type)return b&&(a=b(this)),a},$b.getSubpath=function(a,b){var d=this.getPath();if(d)return c.getSubpath(d,a,b)};var hc=c.easing_formulas={linear:function(a){return a},"<":function(a){return R(a,1.7)},">":function(a){return R(a,.48)},"<>":function(a){var b=.48-a/1.04,c=N.sqrt(.1734+b*b),d=c-b,e=R(Q(d),1/3)*(0>d?-1:1),f=-c-b,g=R(Q(f),1/3)*(0>f?-1:1),h=e+g+.5;return 3*(1-h)*h*h+h*h*h},backIn:function(a){var b=1.70158;return a*a*((b+1)*a-b)},backOut:function(a){a-=1;var b=1.70158;return a*a*((b+1)*a+b)+1},elastic:function(a){return a==!!a?a:R(2,-10*a)*N.sin(2*(a-.075)*S/.3)+1},bounce:function(a){var b,c=7.5625,d=2.75;return 1/d>a?b=c*a*a:2/d>a?(a-=1.5/d,b=c*a*a+.75):2.5/d>a?(a-=2.25/d,b=c*a*a+.9375):(a-=2.625/d,b=c*a*a+.984375),b}};hc.easeIn=hc["ease-in"]=hc["<"],hc.easeOut=hc["ease-out"]=hc[">"],hc.easeInOut=hc["ease-in-out"]=hc["<>"],hc["back-in"]=hc.backIn,hc["back-out"]=hc.backOut;var ic=[],jc=a.requestAnimationFrame||a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame||a.oRequestAnimationFrame||a.msRequestAnimationFrame||function(a){setTimeout(a,16)},kc=function(){for(var a=+new Date,d=0;d<ic.length;d++){var e=ic[d];if(!e.el.removed&&!e.paused){var f,g,h=a-e.start,i=e.ms,j=e.easing,k=e.from,l=e.diff,m=e.to,n=(e.t,e.el),o={},p={};if(e.initstatus?(h=(e.initstatus*e.anim.top-e.prev)/(e.percent-e.prev)*i,e.status=e.initstatus,delete e.initstatus,e.stop&&ic.splice(d--,1)):e.status=(e.prev+(e.percent-e.prev)*(h/i))/e.anim.top,!(0>h))if(i>h){var q=j(h/i);for(var r in k)if(k[z](r)){switch(db[r]){case T:f=+k[r]+q*i*l[r];break;case"colour":f="rgb("+[lc($(k[r].r+q*i*l[r].r)),lc($(k[r].g+q*i*l[r].g)),lc($(k[r].b+q*i*l[r].b))].join(",")+")";break;case"path":f=[];for(var t=0,u=k[r].length;u>t;t++){f[t]=[k[r][t][0]];for(var v=1,w=k[r][t].length;w>v;v++)f[t][v]=+k[r][t][v]+q*i*l[r][t][v];f[t]=f[t].join(H)}f=f.join(H);break;case"transform":if(l[r].real)for(f=[],t=0,u=k[r].length;u>t;t++)for(f[t]=[k[r][t][0]],v=1,w=k[r][t].length;w>v;v++)f[t][v]=k[r][t][v]+q*i*l[r][t][v];else{var x=function(a){return+k[r][a]+q*i*l[r][a]};f=[["m",x(0),x(1),x(2),x(3),x(4),x(5)]]}break;case"csv":if("clip-rect"==r)for(f=[],t=4;t--;)f[t]=+k[r][t]+q*i*l[r][t];break;default:var y=[][E](k[r]);for(f=[],t=n.paper.customAttributes[r].length;t--;)f[t]=+y[t]+q*i*l[r][t]}o[r]=f}n.attr(o),function(a,c,d){setTimeout(function(){b("raphael.anim.frame."+a,c,d)})}(n.id,n,e.anim)}else{if(function(a,d,e){setTimeout(function(){b("raphael.anim.frame."+d.id,d,e),b("raphael.anim.finish."+d.id,d,e),c.is(a,"function")&&a.call(d)})}(e.callback,n,e.anim),n.attr(m),ic.splice(d--,1),e.repeat>1&&!e.next){for(g in m)m[z](g)&&(p[g]=e.totalOrigin[g]);e.el.attr(p),s(e.anim,e.el,e.anim.percents[0],null,e.totalOrigin,e.repeat-1)}e.next&&!e.stop&&s(e.anim,e.el,e.next,null,e.totalOrigin,e.repeat)}}}c.svg&&n&&n.paper&&n.paper.safari(),ic.length&&jc(kc)},lc=function(a){return a>255?255:0>a?0:a};$b.animateWith=function(a,b,d,e,f,g){var h=this;if(h.removed)return g&&g.call(h),h;var i=d instanceof r?d:c.animation(d,e,f,g);s(i,h,i.percents[0],null,h.attr());for(var j=0,k=ic.length;k>j;j++)if(ic[j].anim==b&&ic[j].el==a){ic[k-1].start=ic[j].start;break}return h},$b.onAnimation=function(a){return a?b.on("raphael.anim.frame."+this.id,a):b.unbind("raphael.anim.frame."+this.id),this},r.prototype.delay=function(a){var b=new r(this.anim,this.ms);return b.times=this.times,b.del=+a||0,b},r.prototype.repeat=function(a){var b=new r(this.anim,this.ms);return b.del=this.del,b.times=N.floor(O(a,0))||1,b},c.animation=function(a,b,d,e){if(a instanceof r)return a;(c.is(d,"function")||!d)&&(e=e||d||null,d=null),a=Object(a),b=+b||0;var f,g,h={};for(g in a)a[z](g)&&_(g)!=g&&_(g)+"%"!=g&&(f=!0,h[g]=a[g]);if(f)return d&&(h.easing=d),e&&(h.callback=e),new r({100:h},b);if(e){var i=0;for(var j in a){var k=ab(j);a[z](j)&&k>i&&(i=k)}i+="%",!a[i].callback&&(a[i].callback=e)}return new r(a,b)},$b.animate=function(a,b,d,e){var f=this;if(f.removed)return e&&e.call(f),f;var g=a instanceof r?a:c.animation(a,b,d,e);return s(g,f,g.percents[0],null,f.attr()),f},$b.setTime=function(a,b){return a&&null!=b&&this.status(a,P(b,a.ms)/a.ms),this},$b.status=function(a,b){var c,d,e=[],f=0;if(null!=b)return s(a,this,-1,P(b,1)),this;for(c=ic.length;c>f;f++)if(d=ic[f],d.el.id==this.id&&(!a||d.anim==a)){if(a)return d.status;e.push({anim:d.anim,status:d.status})}return a?0:e},$b.pause=function(a){for(var c=0;c<ic.length;c++)ic[c].el.id!=this.id||a&&ic[c].anim!=a||b("raphael.anim.pause."+this.id,this,ic[c].anim)!==!1&&(ic[c].paused=!0);return this},$b.resume=function(a){for(var c=0;c<ic.length;c++)if(ic[c].el.id==this.id&&(!a||ic[c].anim==a)){var d=ic[c];b("raphael.anim.resume."+this.id,this,d.anim)!==!1&&(delete d.paused,this.status(d.anim,d.status))}return this},$b.stop=function(a){for(var c=0;c<ic.length;c++)ic[c].el.id!=this.id||a&&ic[c].anim!=a||b("raphael.anim.stop."+this.id,this,ic[c].anim)!==!1&&ic.splice(c--,1);return this},b.on("raphael.remove",t),b.on("raphael.clear",t),$b.toString=function(){return"RaphaÃ«lâ€™s object"};var mc=function(a){if(this.items=[],this.length=0,this.type="set",a)for(var b=0,c=a.length;c>b;b++)!a[b]||a[b].constructor!=$b.constructor&&a[b].constructor!=mc||(this[this.items.length]=this.items[this.items.length]=a[b],this.length++)},nc=mc.prototype;nc.push=function(){for(var a,b,c=0,d=arguments.length;d>c;c++)a=arguments[c],!a||a.constructor!=$b.constructor&&a.constructor!=mc||(b=this.items.length,this[b]=this.items[b]=a,this.length++);return this},nc.pop=function(){return this.length&&delete this[this.length--],this.items.pop()},nc.forEach=function(a,b){for(var c=0,d=this.items.length;d>c;c++)if(a.call(b,this.items[c],c)===!1)return this;return this};for(var oc in $b)$b[z](oc)&&(nc[oc]=function(a){return function(){var b=arguments;return this.forEach(function(c){c[a][D](c,b)})}}(oc));return nc.attr=function(a,b){if(a&&c.is(a,V)&&c.is(a[0],"object"))for(var d=0,e=a.length;e>d;d++)this.items[d].attr(a[d]);else for(var f=0,g=this.items.length;g>f;f++)this.items[f].attr(a,b);return this},nc.clear=function(){for(;this.length;)this.pop()},nc.splice=function(a,b){a=0>a?O(this.length+a,0):a,b=O(0,P(this.length-a,b));var c,d=[],e=[],f=[];for(c=2;c<arguments.length;c++)f.push(arguments[c]);for(c=0;b>c;c++)e.push(this[a+c]);for(;c<this.length-a;c++)d.push(this[a+c]);var g=f.length;for(c=0;c<g+d.length;c++)this.items[a+c]=this[a+c]=g>c?f[c]:d[c-g];for(c=this.items.length=this.length-=b-g;this[c];)delete this[c++];return new mc(e)},nc.exclude=function(a){for(var b=0,c=this.length;c>b;b++)if(this[b]==a)return this.splice(b,1),!0},nc.animate=function(a,b,d,e){(c.is(d,"function")||!d)&&(e=d||null);var f,g,h=this.items.length,i=h,j=this;if(!h)return this;e&&(g=function(){!--h&&e.call(j)}),d=c.is(d,U)?d:g;var k=c.animation(a,b,d,g);for(f=this.items[--i].animate(k);i--;)this.items[i]&&!this.items[i].removed&&this.items[i].animateWith(f,k,k),this.items[i]&&!this.items[i].removed||h--;return this},nc.insertAfter=function(a){for(var b=this.items.length;b--;)this.items[b].insertAfter(a);return this},nc.getBBox=function(){for(var a=[],b=[],c=[],d=[],e=this.items.length;e--;)if(!this.items[e].removed){var f=this.items[e].getBBox();a.push(f.x),b.push(f.y),c.push(f.x+f.width),d.push(f.y+f.height)}return a=P[D](0,a),b=P[D](0,b),c=O[D](0,c),d=O[D](0,d),{x:a,y:b,x2:c,y2:d,width:c-a,height:d-b}},nc.clone=function(a){a=this.paper.set();for(var b=0,c=this.items.length;c>b;b++)a.push(this.items[b].clone());return a},nc.toString=function(){return"RaphaÃ«lâ€˜s set"},nc.glow=function(a){var b=this.paper.set();return this.forEach(function(c){var d=c.glow(a);null!=d&&d.forEach(function(a){b.push(a)})}),b},nc.isPointInside=function(a,b){var c=!1;return this.forEach(function(d){return d.isPointInside(a,b)?(c=!0,!1):void 0}),c},c.registerFont=function(a){if(!a.face)return a;this.fonts=this.fonts||{};var b={w:a.w,face:{},glyphs:{}},c=a.face["font-family"];for(var d in a.face)a.face[z](d)&&(b.face[d]=a.face[d]);if(this.fonts[c]?this.fonts[c].push(b):this.fonts[c]=[b],!a.svg){b.face["units-per-em"]=ab(a.face["units-per-em"],10);for(var e in a.glyphs)if(a.glyphs[z](e)){var f=a.glyphs[e];if(b.glyphs[e]={w:f.w,k:{},d:f.d&&"M"+f.d.replace(/[mlcxtrv]/g,function(a){return{l:"L",c:"C",x:"z",t:"m",r:"l",v:"c"}[a]||"M"})+"z"},f.k)for(var g in f.k)f[z](g)&&(b.glyphs[e].k[g]=f.k[g])}}return a},v.getFont=function(a,b,d,e){if(e=e||"normal",d=d||"normal",b=+b||{normal:400,bold:700,lighter:300,bolder:800}[b]||400,c.fonts){var f=c.fonts[a];if(!f){var g=new RegExp("(^|\\s)"+a.replace(/[^\w\d\s+!~.:_-]/g,G)+"(\\s|$)","i");for(var h in c.fonts)if(c.fonts[z](h)&&g.test(h)){f=c.fonts[h];break}}var i;if(f)for(var j=0,k=f.length;k>j&&(i=f[j],i.face["font-weight"]!=b||i.face["font-style"]!=d&&i.face["font-style"]||i.face["font-stretch"]!=e);j++);return i}},v.print=function(a,b,d,e,f,g,h,i){g=g||"middle",h=O(P(h||0,1),-1),i=O(P(i||1,3),1);var j,k=I(d)[J](G),l=0,m=0,n=G;if(c.is(e,"string")&&(e=this.getFont(e)),e){j=(f||16)/e.face["units-per-em"];for(var o=e.face.bbox[J](w),p=+o[0],q=o[3]-o[1],r=0,s=+o[1]+("baseline"==g?q+ +e.face.descent:q/2),t=0,u=k.length;u>t;t++){if("\n"==k[t])l=0,x=0,m=0,r+=q*i;else{var v=m&&e.glyphs[k[t-1]]||{},x=e.glyphs[k[t]];l+=m?(v.w||e.w)+(v.k&&v.k[k[t]]||0)+e.w*h:0,m=1}x&&x.d&&(n+=c.transformPath(x.d,["t",l*j,r*j,"s",j,j,p,s,"t",(a-p)/j,(b-s)/j]))}}return this.path(n).attr({fill:"#000",stroke:"none"})},v.add=function(a){if(c.is(a,"array"))for(var b,d=this.set(),e=0,f=a.length;f>e;e++)b=a[e]||{},x[z](b.type)&&d.push(this[b.type]().attr(b));return d},c.format=function(a,b){var d=c.is(b,V)?[0][E](b):arguments;return a&&c.is(a,U)&&d.length-1&&(a=a.replace(y,function(a,b){return null==d[++b]?G:d[b]})),a||G},c.fullfill=function(){var a=/\{([^\}]+)\}/g,b=/(?:(?:^|\.)(.+?)(?=\[|\.|$|\()|\[('|")(.+?)\2\])(\(\))?/g,c=function(a,c,d){var e=d;return c.replace(b,function(a,b,c,d,f){b=b||d,e&&(b in e&&(e=e[b]),"function"==typeof e&&f&&(e=e()))}),e=(null==e||e==d?a:e)+""};return function(b,d){return String(b).replace(a,function(a,b){return c(a,b,d)})}}(),c.ninja=function(){return B.was?A.win.Raphael=B.is:delete Raphael,c},c.st=nc,b.on("raphael.DOMload",function(){u=!0}),function(a,b,d){function e(){/in/.test(a.readyState)?setTimeout(e,9):c.eve("raphael.DOMload")}null==a.readyState&&a.addEventListener&&(a.addEventListener(b,d=function(){a.removeEventListener(b,d,!1),a.readyState="complete"},!1),a.readyState="loading"),e()}(document,"DOMContentLoaded"),function(){if(c.svg){var a="hasOwnProperty",b=String,d=parseFloat,e=parseInt,f=Math,g=f.max,h=f.abs,i=f.pow,j=/[, ]+/,k=c.eve,l="",m=" ",n="http://www.w3.org/1999/xlink",o={block:"M5,0 0,2.5 5,5z",classic:"M5,0 0,2.5 5,5 3.5,3 3.5,2z",diamond:"M2.5,0 5,2.5 2.5,5 0,2.5z",open:"M6,1 1,3.5 6,6",oval:"M2.5,0A2.5,2.5,0,0,1,2.5,5 2.5,2.5,0,0,1,2.5,0z"},p={};c.toString=function(){return"Your browser supports SVG.\nYou are running RaphaÃ«l "+this.version};var q=function(d,e){if(e){"string"==typeof d&&(d=q(d));for(var f in e)e[a](f)&&("xlink:"==f.substring(0,6)?d.setAttributeNS(n,f.substring(6),b(e[f])):d.setAttribute(f,b(e[f])))}else d=c._g.doc.createElementNS("http://www.w3.org/2000/svg",d),d.style&&(d.style.webkitTapHighlightColor="rgba(0,0,0,0)");return d},r=function(a,e){var j="linear",k=a.id+e,m=.5,n=.5,o=a.node,p=a.paper,r=o.style,s=c._g.doc.getElementById(k);if(!s){if(e=b(e).replace(c._radial_gradient,function(a,b,c){if(j="radial",b&&c){m=d(b),n=d(c);var e=2*(n>.5)-1;i(m-.5,2)+i(n-.5,2)>.25&&(n=f.sqrt(.25-i(m-.5,2))*e+.5)&&.5!=n&&(n=n.toFixed(5)-1e-5*e)}return l}),e=e.split(/\s*\-\s*/),"linear"==j){var t=e.shift();if(t=-d(t),isNaN(t))return null;var u=[0,0,f.cos(c.rad(t)),f.sin(c.rad(t))],v=1/(g(h(u[2]),h(u[3]))||1);u[2]*=v,u[3]*=v,u[2]<0&&(u[0]=-u[2],u[2]=0),u[3]<0&&(u[1]=-u[3],u[3]=0)}var w=c._parseDots(e);if(!w)return null;if(k=k.replace(/[\(\)\s,\xb0#]/g,"_"),a.gradient&&k!=a.gradient.id&&(p.defs.removeChild(a.gradient),delete a.gradient),!a.gradient){s=q(j+"Gradient",{id:k}),a.gradient=s,q(s,"radial"==j?{fx:m,fy:n}:{x1:u[0],y1:u[1],x2:u[2],y2:u[3],gradientTransform:a.matrix.invert()}),p.defs.appendChild(s);for(var x=0,y=w.length;y>x;x++)s.appendChild(q("stop",{offset:w[x].offset?w[x].offset:x?"100%":"0%","stop-color":w[x].color||"#fff"}))}}return q(o,{fill:"url('"+document.location+"#"+k+"')",opacity:1,"fill-opacity":1}),r.fill=l,r.opacity=1,r.fillOpacity=1,1},s=function(a){var b=a.getBBox(1);q(a.pattern,{patternTransform:a.matrix.invert()+" translate("+b.x+","+b.y+")"})},t=function(d,e,f){if("path"==d.type){for(var g,h,i,j,k,m=b(e).toLowerCase().split("-"),n=d.paper,r=f?"end":"start",s=d.node,t=d.attrs,u=t["stroke-width"],v=m.length,w="classic",x=3,y=3,z=5;v--;)switch(m[v]){case"block":case"classic":case"oval":case"diamond":case"open":case"none":w=m[v];break;case"wide":y=5;break;case"narrow":y=2;break;case"long":x=5;break;case"short":x=2}if("open"==w?(x+=2,y+=2,z+=2,i=1,j=f?4:1,k={fill:"none",stroke:t.stroke}):(j=i=x/2,k={fill:t.stroke,stroke:"none"}),d._.arrows?f?(d._.arrows.endPath&&p[d._.arrows.endPath]--,d._.arrows.endMarker&&p[d._.arrows.endMarker]--):(d._.arrows.startPath&&p[d._.arrows.startPath]--,d._.arrows.startMarker&&p[d._.arrows.startMarker]--):d._.arrows={},"none"!=w){var A="raphael-marker-"+w,B="raphael-marker-"+r+w+x+y+"-obj"+d.id;c._g.doc.getElementById(A)?p[A]++:(n.defs.appendChild(q(q("path"),{"stroke-linecap":"round",d:o[w],id:A})),p[A]=1);var C,D=c._g.doc.getElementById(B);D?(p[B]++,C=D.getElementsByTagName("use")[0]):(D=q(q("marker"),{id:B,markerHeight:y,markerWidth:x,orient:"auto",refX:j,refY:y/2}),C=q(q("use"),{"xlink:href":"#"+A,transform:(f?"rotate(180 "+x/2+" "+y/2+") ":l)+"scale("+x/z+","+y/z+")","stroke-width":(1/((x/z+y/z)/2)).toFixed(4)}),D.appendChild(C),n.defs.appendChild(D),p[B]=1),q(C,k);var E=i*("diamond"!=w&&"oval"!=w);f?(g=d._.arrows.startdx*u||0,h=c.getTotalLength(t.path)-E*u):(g=E*u,h=c.getTotalLength(t.path)-(d._.arrows.enddx*u||0)),k={},k["marker-"+r]="url(#"+B+")",(h||g)&&(k.d=c.getSubpath(t.path,g,h)),q(s,k),d._.arrows[r+"Path"]=A,d._.arrows[r+"Marker"]=B,d._.arrows[r+"dx"]=E,d._.arrows[r+"Type"]=w,d._.arrows[r+"String"]=e}else f?(g=d._.arrows.startdx*u||0,h=c.getTotalLength(t.path)-g):(g=0,h=c.getTotalLength(t.path)-(d._.arrows.enddx*u||0)),d._.arrows[r+"Path"]&&q(s,{d:c.getSubpath(t.path,g,h)}),delete d._.arrows[r+"Path"],delete d._.arrows[r+"Marker"],delete d._.arrows[r+"dx"],delete d._.arrows[r+"Type"],delete d._.arrows[r+"String"];for(k in p)if(p[a](k)&&!p[k]){var F=c._g.doc.getElementById(k);F&&F.parentNode.removeChild(F)}}},u={"":[0],none:[0],"-":[3,1],".":[1,1],"-.":[3,1,1,1],"-..":[3,1,1,1,1,1],". ":[1,3],"- ":[4,3],"--":[8,3],"- .":[4,3,1,3],"--.":[8,3,1,3],"--..":[8,3,1,3,1,3]},v=function(a,c,d){if(c=u[b(c).toLowerCase()]){for(var e=a.attrs["stroke-width"]||"1",f={round:e,square:e,butt:0}[a.attrs["stroke-linecap"]||d["stroke-linecap"]]||0,g=[],h=c.length;h--;)g[h]=c[h]*e+(h%2?1:-1)*f;q(a.node,{"stroke-dasharray":g.join(",")})}},w=function(d,f){var i=d.node,k=d.attrs,m=i.style.visibility;i.style.visibility="hidden";for(var o in f)if(f[a](o)){if(!c._availableAttrs[a](o))continue;var p=f[o];switch(k[o]=p,o){case"blur":d.blur(p);break;case"title":var u=i.getElementsByTagName("title");if(u.length&&(u=u[0]))u.firstChild.nodeValue=p;else{u=q("title");var w=c._g.doc.createTextNode(p);u.appendChild(w),i.appendChild(u)}break;case"href":case"target":var x=i.parentNode;if("a"!=x.tagName.toLowerCase()){var z=q("a");x.insertBefore(z,i),z.appendChild(i),x=z}"target"==o?x.setAttributeNS(n,"show","blank"==p?"new":p):x.setAttributeNS(n,o,p);break;case"cursor":i.style.cursor=p;break;case"transform":d.transform(p);break;case"arrow-start":t(d,p);break;case"arrow-end":t(d,p,1);break;case"clip-rect":var A=b(p).split(j);if(4==A.length){d.clip&&d.clip.parentNode.parentNode.removeChild(d.clip.parentNode);var B=q("clipPath"),C=q("rect");B.id=c.createUUID(),q(C,{x:A[0],y:A[1],width:A[2],height:A[3]}),B.appendChild(C),d.paper.defs.appendChild(B),q(i,{"clip-path":"url(#"+B.id+")"}),d.clip=C}if(!p){var D=i.getAttribute("clip-path");if(D){var E=c._g.doc.getElementById(D.replace(/(^url\(#|\)$)/g,l));E&&E.parentNode.removeChild(E),q(i,{"clip-path":l}),delete d.clip}}break;case"path":"path"==d.type&&(q(i,{d:p?k.path=c._pathToAbsolute(p):"M0,0"}),d._.dirty=1,d._.arrows&&("startString"in d._.arrows&&t(d,d._.arrows.startString),"endString"in d._.arrows&&t(d,d._.arrows.endString,1)));break;case"width":if(i.setAttribute(o,p),d._.dirty=1,!k.fx)break;o="x",p=k.x;case"x":k.fx&&(p=-k.x-(k.width||0));case"rx":if("rx"==o&&"rect"==d.type)break;case"cx":i.setAttribute(o,p),d.pattern&&s(d),d._.dirty=1;break;case"height":if(i.setAttribute(o,p),d._.dirty=1,!k.fy)break;o="y",p=k.y;case"y":k.fy&&(p=-k.y-(k.height||0));case"ry":if("ry"==o&&"rect"==d.type)break;case"cy":i.setAttribute(o,p),d.pattern&&s(d),d._.dirty=1;break;case"r":"rect"==d.type?q(i,{rx:p,ry:p}):i.setAttribute(o,p),d._.dirty=1;break;case"src":"image"==d.type&&i.setAttributeNS(n,"href",p);break;case"stroke-width":(1!=d._.sx||1!=d._.sy)&&(p/=g(h(d._.sx),h(d._.sy))||1),i.setAttribute(o,p),k["stroke-dasharray"]&&v(d,k["stroke-dasharray"],f),d._.arrows&&("startString"in d._.arrows&&t(d,d._.arrows.startString),"endString"in d._.arrows&&t(d,d._.arrows.endString,1));break;case"stroke-dasharray":v(d,p,f);break;case"fill":var F=b(p).match(c._ISURL);if(F){B=q("pattern");var G=q("image");B.id=c.createUUID(),q(B,{x:0,y:0,patternUnits:"userSpaceOnUse",height:1,width:1}),q(G,{x:0,y:0,"xlink:href":F[1]}),B.appendChild(G),function(a){c._preload(F[1],function(){var b=this.offsetWidth,c=this.offsetHeight;q(a,{width:b,height:c}),q(G,{width:b,height:c}),d.paper.safari()})}(B),d.paper.defs.appendChild(B),q(i,{fill:"url(#"+B.id+")"}),d.pattern=B,d.pattern&&s(d);break}var H=c.getRGB(p);if(H.error){if(("circle"==d.type||"ellipse"==d.type||"r"!=b(p).charAt())&&r(d,p)){if("opacity"in k||"fill-opacity"in k){var I=c._g.doc.getElementById(i.getAttribute("fill").replace(/^url\(#|\)$/g,l));if(I){var J=I.getElementsByTagName("stop");q(J[J.length-1],{"stop-opacity":("opacity"in k?k.opacity:1)*("fill-opacity"in k?k["fill-opacity"]:1)})}}k.gradient=p,k.fill="none";break}}else delete f.gradient,delete k.gradient,!c.is(k.opacity,"undefined")&&c.is(f.opacity,"undefined")&&q(i,{opacity:k.opacity}),!c.is(k["fill-opacity"],"undefined")&&c.is(f["fill-opacity"],"undefined")&&q(i,{"fill-opacity":k["fill-opacity"]});H[a]("opacity")&&q(i,{"fill-opacity":H.opacity>1?H.opacity/100:H.opacity});case"stroke":H=c.getRGB(p),i.setAttribute(o,H.hex),"stroke"==o&&H[a]("opacity")&&q(i,{"stroke-opacity":H.opacity>1?H.opacity/100:H.opacity}),"stroke"==o&&d._.arrows&&("startString"in d._.arrows&&t(d,d._.arrows.startString),"endString"in d._.arrows&&t(d,d._.arrows.endString,1));break;case"gradient":("circle"==d.type||"ellipse"==d.type||"r"!=b(p).charAt())&&r(d,p);break;
    case"opacity":k.gradient&&!k[a]("stroke-opacity")&&q(i,{"stroke-opacity":p>1?p/100:p});case"fill-opacity":if(k.gradient){I=c._g.doc.getElementById(i.getAttribute("fill").replace(/^url\(#|\)$/g,l)),I&&(J=I.getElementsByTagName("stop"),q(J[J.length-1],{"stop-opacity":p}));break}default:"font-size"==o&&(p=e(p,10)+"px");var K=o.replace(/(\-.)/g,function(a){return a.substring(1).toUpperCase()});i.style[K]=p,d._.dirty=1,i.setAttribute(o,p)}}y(d,f),i.style.visibility=m},x=1.2,y=function(d,f){if("text"==d.type&&(f[a]("text")||f[a]("font")||f[a]("font-size")||f[a]("x")||f[a]("y"))){var g=d.attrs,h=d.node,i=h.firstChild?e(c._g.doc.defaultView.getComputedStyle(h.firstChild,l).getPropertyValue("font-size"),10):10;if(f[a]("text")){for(g.text=f.text;h.firstChild;)h.removeChild(h.firstChild);for(var j,k=b(f.text).split("\n"),m=[],n=0,o=k.length;o>n;n++)j=q("tspan"),n&&q(j,{dy:i*x,x:g.x}),j.appendChild(c._g.doc.createTextNode(k[n])),h.appendChild(j),m[n]=j}else for(m=h.getElementsByTagName("tspan"),n=0,o=m.length;o>n;n++)n?q(m[n],{dy:i*x,x:g.x}):q(m[0],{dy:0});q(h,{x:g.x,y:g.y}),d._.dirty=1;var p=d._getBBox(),r=g.y-(p.y+p.height/2);r&&c.is(r,"finite")&&q(m[0],{dy:r})}},z=function(a){return a.parentNode&&"a"===a.parentNode.tagName.toLowerCase()?a.parentNode:a},A=function(a,b){this[0]=this.node=a,a.raphael=!0,this.id=c._oid++,a.raphaelid=this.id,this.matrix=c.matrix(),this.realPath=null,this.paper=b,this.attrs=this.attrs||{},this._={transform:[],sx:1,sy:1,deg:0,dx:0,dy:0,dirty:1},!b.bottom&&(b.bottom=this),this.prev=b.top,b.top&&(b.top.next=this),b.top=this,this.next=null},B=c.el;A.prototype=B,B.constructor=A,c._engine.path=function(a,b){var c=q("path");b.canvas&&b.canvas.appendChild(c);var d=new A(c,b);return d.type="path",w(d,{fill:"none",stroke:"#000",path:a}),d},B.rotate=function(a,c,e){if(this.removed)return this;if(a=b(a).split(j),a.length-1&&(c=d(a[1]),e=d(a[2])),a=d(a[0]),null==e&&(c=e),null==c||null==e){var f=this.getBBox(1);c=f.x+f.width/2,e=f.y+f.height/2}return this.transform(this._.transform.concat([["r",a,c,e]])),this},B.scale=function(a,c,e,f){if(this.removed)return this;if(a=b(a).split(j),a.length-1&&(c=d(a[1]),e=d(a[2]),f=d(a[3])),a=d(a[0]),null==c&&(c=a),null==f&&(e=f),null==e||null==f)var g=this.getBBox(1);return e=null==e?g.x+g.width/2:e,f=null==f?g.y+g.height/2:f,this.transform(this._.transform.concat([["s",a,c,e,f]])),this},B.translate=function(a,c){return this.removed?this:(a=b(a).split(j),a.length-1&&(c=d(a[1])),a=d(a[0])||0,c=+c||0,this.transform(this._.transform.concat([["t",a,c]])),this)},B.transform=function(b){var d=this._;if(null==b)return d.transform;if(c._extractTransform(this,b),this.clip&&q(this.clip,{transform:this.matrix.invert()}),this.pattern&&s(this),this.node&&q(this.node,{transform:this.matrix}),1!=d.sx||1!=d.sy){var e=this.attrs[a]("stroke-width")?this.attrs["stroke-width"]:1;this.attr({"stroke-width":e})}return this},B.hide=function(){return!this.removed&&this.paper.safari(this.node.style.display="none"),this},B.show=function(){return!this.removed&&this.paper.safari(this.node.style.display=""),this},B.remove=function(){var a=z(this.node);if(!this.removed&&a.parentNode){var b=this.paper;b.__set__&&b.__set__.exclude(this),k.unbind("raphael.*.*."+this.id),this.gradient&&b.defs.removeChild(this.gradient),c._tear(this,b),a.parentNode.removeChild(a),this.removeData();for(var d in this)this[d]="function"==typeof this[d]?c._removedFactory(d):null;this.removed=!0}},B._getBBox=function(){if("none"==this.node.style.display){this.show();var a=!0}var b,c=!1;this.paper.canvas.parentElement?b=this.paper.canvas.parentElement.style:this.paper.canvas.parentNode&&(b=this.paper.canvas.parentNode.style),b&&"none"==b.display&&(c=!0,b.display="");var d={};try{d=this.node.getBBox()}catch(e){d={x:this.node.clientLeft,y:this.node.clientTop,width:this.node.clientWidth,height:this.node.clientHeight}}finally{d=d||{},c&&(b.display="none")}return a&&this.hide(),d},B.attr=function(b,d){if(this.removed)return this;if(null==b){var e={};for(var f in this.attrs)this.attrs[a](f)&&(e[f]=this.attrs[f]);return e.gradient&&"none"==e.fill&&(e.fill=e.gradient)&&delete e.gradient,e.transform=this._.transform,e}if(null==d&&c.is(b,"string")){if("fill"==b&&"none"==this.attrs.fill&&this.attrs.gradient)return this.attrs.gradient;if("transform"==b)return this._.transform;for(var g=b.split(j),h={},i=0,l=g.length;l>i;i++)b=g[i],h[b]=b in this.attrs?this.attrs[b]:c.is(this.paper.customAttributes[b],"function")?this.paper.customAttributes[b].def:c._availableAttrs[b];return l-1?h:h[g[0]]}if(null==d&&c.is(b,"array")){for(h={},i=0,l=b.length;l>i;i++)h[b[i]]=this.attr(b[i]);return h}if(null!=d){var m={};m[b]=d}else null!=b&&c.is(b,"object")&&(m=b);for(var n in m)k("raphael.attr."+n+"."+this.id,this,m[n]);for(n in this.paper.customAttributes)if(this.paper.customAttributes[a](n)&&m[a](n)&&c.is(this.paper.customAttributes[n],"function")){var o=this.paper.customAttributes[n].apply(this,[].concat(m[n]));this.attrs[n]=m[n];for(var p in o)o[a](p)&&(m[p]=o[p])}return w(this,m),this},B.toFront=function(){if(this.removed)return this;var a=z(this.node);a.parentNode.appendChild(a);var b=this.paper;return b.top!=this&&c._tofront(this,b),this},B.toBack=function(){if(this.removed)return this;var a=z(this.node),b=a.parentNode;b.insertBefore(a,b.firstChild),c._toback(this,this.paper);this.paper;return this},B.insertAfter=function(a){if(this.removed||!a)return this;var b=z(this.node),d=z(a.node||a[a.length-1].node);return d.nextSibling?d.parentNode.insertBefore(b,d.nextSibling):d.parentNode.appendChild(b),c._insertafter(this,a,this.paper),this},B.insertBefore=function(a){if(this.removed||!a)return this;var b=z(this.node),d=z(a.node||a[0].node);return d.parentNode.insertBefore(b,d),c._insertbefore(this,a,this.paper),this},B.blur=function(a){var b=this;if(0!==+a){var d=q("filter"),e=q("feGaussianBlur");b.attrs.blur=a,d.id=c.createUUID(),q(e,{stdDeviation:+a||1.5}),d.appendChild(e),b.paper.defs.appendChild(d),b._blur=d,q(b.node,{filter:"url(#"+d.id+")"})}else b._blur&&(b._blur.parentNode.removeChild(b._blur),delete b._blur,delete b.attrs.blur),b.node.removeAttribute("filter");return b},c._engine.circle=function(a,b,c,d){var e=q("circle");a.canvas&&a.canvas.appendChild(e);var f=new A(e,a);return f.attrs={cx:b,cy:c,r:d,fill:"none",stroke:"#000"},f.type="circle",q(e,f.attrs),f},c._engine.rect=function(a,b,c,d,e,f){var g=q("rect");a.canvas&&a.canvas.appendChild(g);var h=new A(g,a);return h.attrs={x:b,y:c,width:d,height:e,rx:f||0,ry:f||0,fill:"none",stroke:"#000"},h.type="rect",q(g,h.attrs),h},c._engine.ellipse=function(a,b,c,d,e){var f=q("ellipse");a.canvas&&a.canvas.appendChild(f);var g=new A(f,a);return g.attrs={cx:b,cy:c,rx:d,ry:e,fill:"none",stroke:"#000"},g.type="ellipse",q(f,g.attrs),g},c._engine.image=function(a,b,c,d,e,f){var g=q("image");q(g,{x:c,y:d,width:e,height:f,preserveAspectRatio:"none"}),g.setAttributeNS(n,"href",b),a.canvas&&a.canvas.appendChild(g);var h=new A(g,a);return h.attrs={x:c,y:d,width:e,height:f,src:b},h.type="image",h},c._engine.text=function(a,b,d,e){var f=q("text");a.canvas&&a.canvas.appendChild(f);var g=new A(f,a);return g.attrs={x:b,y:d,"text-anchor":"middle",text:e,"font-family":c._availableAttrs["font-family"],"font-size":c._availableAttrs["font-size"],stroke:"none",fill:"#000"},g.type="text",w(g,g.attrs),g},c._engine.setSize=function(a,b){return this.width=a||this.width,this.height=b||this.height,this.canvas.setAttribute("width",this.width),this.canvas.setAttribute("height",this.height),this._viewBox&&this.setViewBox.apply(this,this._viewBox),this},c._engine.create=function(){var a=c._getContainer.apply(0,arguments),b=a&&a.container,d=a.x,e=a.y,f=a.width,g=a.height;if(!b)throw new Error("SVG container not found.");var h,i=q("svg"),j="overflow:hidden;";return d=d||0,e=e||0,f=f||512,g=g||342,q(i,{height:g,version:1.1,width:f,xmlns:"http://www.w3.org/2000/svg","xmlns:xlink":"http://www.w3.org/1999/xlink"}),1==b?(i.style.cssText=j+"position:absolute;left:"+d+"px;top:"+e+"px",c._g.doc.body.appendChild(i),h=1):(i.style.cssText=j+"position:relative",b.firstChild?b.insertBefore(i,b.firstChild):b.appendChild(i)),b=new c._Paper,b.width=f,b.height=g,b.canvas=i,b.clear(),b._left=b._top=0,h&&(b.renderfix=function(){}),b.renderfix(),b},c._engine.setViewBox=function(a,b,c,d,e){k("raphael.setViewBox",this,this._viewBox,[a,b,c,d,e]);var f,h,i=this.getSize(),j=g(c/i.width,d/i.height),l=this.top,n=e?"xMidYMid meet":"xMinYMin";for(null==a?(this._vbSize&&(j=1),delete this._vbSize,f="0 0 "+this.width+m+this.height):(this._vbSize=j,f=a+m+b+m+c+m+d),q(this.canvas,{viewBox:f,preserveAspectRatio:n});j&&l;)h="stroke-width"in l.attrs?l.attrs["stroke-width"]:1,l.attr({"stroke-width":h}),l._.dirty=1,l._.dirtyT=1,l=l.prev;return this._viewBox=[a,b,c,d,!!e],this},c.prototype.renderfix=function(){var a,b=this.canvas,c=b.style;try{a=b.getScreenCTM()||b.createSVGMatrix()}catch(d){a=b.createSVGMatrix()}var e=-a.e%1,f=-a.f%1;(e||f)&&(e&&(this._left=(this._left+e)%1,c.left=this._left+"px"),f&&(this._top=(this._top+f)%1,c.top=this._top+"px"))},c.prototype.clear=function(){c.eve("raphael.clear",this);for(var a=this.canvas;a.firstChild;)a.removeChild(a.firstChild);this.bottom=this.top=null,(this.desc=q("desc")).appendChild(c._g.doc.createTextNode("Created with RaphaÃ«l "+c.version)),a.appendChild(this.desc),a.appendChild(this.defs=q("defs"))},c.prototype.remove=function(){k("raphael.remove",this),this.canvas.parentNode&&this.canvas.parentNode.removeChild(this.canvas);for(var a in this)this[a]="function"==typeof this[a]?c._removedFactory(a):null};var C=c.st;for(var D in B)B[a](D)&&!C[a](D)&&(C[D]=function(a){return function(){var b=arguments;return this.forEach(function(c){c[a].apply(c,b)})}}(D))}}(),function(){if(c.vml){var a="hasOwnProperty",b=String,d=parseFloat,e=Math,f=e.round,g=e.max,h=e.min,i=e.abs,j="fill",k=/[, ]+/,l=c.eve,m=" progid:DXImageTransform.Microsoft",n=" ",o="",p={M:"m",L:"l",C:"c",Z:"x",m:"t",l:"r",c:"v",z:"x"},q=/([clmz]),?([^clmz]*)/gi,r=/ progid:\S+Blur\([^\)]+\)/g,s=/-?[^,\s-]+/g,t="position:absolute;left:0;top:0;width:1px;height:1px;behavior:url(#default#VML)",u=21600,v={path:1,rect:1,image:1},w={circle:1,ellipse:1},x=function(a){var d=/[ahqstv]/gi,e=c._pathToAbsolute;if(b(a).match(d)&&(e=c._path2curve),d=/[clmz]/g,e==c._pathToAbsolute&&!b(a).match(d)){var g=b(a).replace(q,function(a,b,c){var d=[],e="m"==b.toLowerCase(),g=p[b];return c.replace(s,function(a){e&&2==d.length&&(g+=d+p["m"==b?"l":"L"],d=[]),d.push(f(a*u))}),g+d});return g}var h,i,j=e(a);g=[];for(var k=0,l=j.length;l>k;k++){h=j[k],i=j[k][0].toLowerCase(),"z"==i&&(i="x");for(var m=1,r=h.length;r>m;m++)i+=f(h[m]*u)+(m!=r-1?",":o);g.push(i)}return g.join(n)},y=function(a,b,d){var e=c.matrix();return e.rotate(-a,.5,.5),{dx:e.x(b,d),dy:e.y(b,d)}},z=function(a,b,c,d,e,f){var g=a._,h=a.matrix,k=g.fillpos,l=a.node,m=l.style,o=1,p="",q=u/b,r=u/c;if(m.visibility="hidden",b&&c){if(l.coordsize=i(q)+n+i(r),m.rotation=f*(0>b*c?-1:1),f){var s=y(f,d,e);d=s.dx,e=s.dy}if(0>b&&(p+="x"),0>c&&(p+=" y")&&(o=-1),m.flip=p,l.coordorigin=d*-q+n+e*-r,k||g.fillsize){var t=l.getElementsByTagName(j);t=t&&t[0],l.removeChild(t),k&&(s=y(f,h.x(k[0],k[1]),h.y(k[0],k[1])),t.position=s.dx*o+n+s.dy*o),g.fillsize&&(t.size=g.fillsize[0]*i(b)+n+g.fillsize[1]*i(c)),l.appendChild(t)}m.visibility="visible"}};c.toString=function(){return"Your browser doesnâ€™t support SVG. Falling down to VML.\nYou are running RaphaÃ«l "+this.version};var A=function(a,c,d){for(var e=b(c).toLowerCase().split("-"),f=d?"end":"start",g=e.length,h="classic",i="medium",j="medium";g--;)switch(e[g]){case"block":case"classic":case"oval":case"diamond":case"open":case"none":h=e[g];break;case"wide":case"narrow":j=e[g];break;case"long":case"short":i=e[g]}var k=a.node.getElementsByTagName("stroke")[0];k[f+"arrow"]=h,k[f+"arrowlength"]=i,k[f+"arrowwidth"]=j},B=function(e,i){e.attrs=e.attrs||{};var l=e.node,m=e.attrs,p=l.style,q=v[e.type]&&(i.x!=m.x||i.y!=m.y||i.width!=m.width||i.height!=m.height||i.cx!=m.cx||i.cy!=m.cy||i.rx!=m.rx||i.ry!=m.ry||i.r!=m.r),r=w[e.type]&&(m.cx!=i.cx||m.cy!=i.cy||m.r!=i.r||m.rx!=i.rx||m.ry!=i.ry),s=e;for(var t in i)i[a](t)&&(m[t]=i[t]);if(q&&(m.path=c._getPath[e.type](e),e._.dirty=1),i.href&&(l.href=i.href),i.title&&(l.title=i.title),i.target&&(l.target=i.target),i.cursor&&(p.cursor=i.cursor),"blur"in i&&e.blur(i.blur),(i.path&&"path"==e.type||q)&&(l.path=x(~b(m.path).toLowerCase().indexOf("r")?c._pathToAbsolute(m.path):m.path),e._.dirty=1,"image"==e.type&&(e._.fillpos=[m.x,m.y],e._.fillsize=[m.width,m.height],z(e,1,1,0,0,0))),"transform"in i&&e.transform(i.transform),r){var y=+m.cx,B=+m.cy,D=+m.rx||+m.r||0,E=+m.ry||+m.r||0;l.path=c.format("ar{0},{1},{2},{3},{4},{1},{4},{1}x",f((y-D)*u),f((B-E)*u),f((y+D)*u),f((B+E)*u),f(y*u)),e._.dirty=1}if("clip-rect"in i){var G=b(i["clip-rect"]).split(k);if(4==G.length){G[2]=+G[2]+ +G[0],G[3]=+G[3]+ +G[1];var H=l.clipRect||c._g.doc.createElement("div"),I=H.style;I.clip=c.format("rect({1}px {2}px {3}px {0}px)",G),l.clipRect||(I.position="absolute",I.top=0,I.left=0,I.width=e.paper.width+"px",I.height=e.paper.height+"px",l.parentNode.insertBefore(H,l),H.appendChild(l),l.clipRect=H)}i["clip-rect"]||l.clipRect&&(l.clipRect.style.clip="auto")}if(e.textpath){var J=e.textpath.style;i.font&&(J.font=i.font),i["font-family"]&&(J.fontFamily='"'+i["font-family"].split(",")[0].replace(/^['"]+|['"]+$/g,o)+'"'),i["font-size"]&&(J.fontSize=i["font-size"]),i["font-weight"]&&(J.fontWeight=i["font-weight"]),i["font-style"]&&(J.fontStyle=i["font-style"])}if("arrow-start"in i&&A(s,i["arrow-start"]),"arrow-end"in i&&A(s,i["arrow-end"],1),null!=i.opacity||null!=i["stroke-width"]||null!=i.fill||null!=i.src||null!=i.stroke||null!=i["stroke-width"]||null!=i["stroke-opacity"]||null!=i["fill-opacity"]||null!=i["stroke-dasharray"]||null!=i["stroke-miterlimit"]||null!=i["stroke-linejoin"]||null!=i["stroke-linecap"]){var K=l.getElementsByTagName(j),L=!1;if(K=K&&K[0],!K&&(L=K=F(j)),"image"==e.type&&i.src&&(K.src=i.src),i.fill&&(K.on=!0),(null==K.on||"none"==i.fill||null===i.fill)&&(K.on=!1),K.on&&i.fill){var M=b(i.fill).match(c._ISURL);if(M){K.parentNode==l&&l.removeChild(K),K.rotate=!0,K.src=M[1],K.type="tile";var N=e.getBBox(1);K.position=N.x+n+N.y,e._.fillpos=[N.x,N.y],c._preload(M[1],function(){e._.fillsize=[this.offsetWidth,this.offsetHeight]})}else K.color=c.getRGB(i.fill).hex,K.src=o,K.type="solid",c.getRGB(i.fill).error&&(s.type in{circle:1,ellipse:1}||"r"!=b(i.fill).charAt())&&C(s,i.fill,K)&&(m.fill="none",m.gradient=i.fill,K.rotate=!1)}if("fill-opacity"in i||"opacity"in i){var O=((+m["fill-opacity"]+1||2)-1)*((+m.opacity+1||2)-1)*((+c.getRGB(i.fill).o+1||2)-1);O=h(g(O,0),1),K.opacity=O,K.src&&(K.color="none")}l.appendChild(K);var P=l.getElementsByTagName("stroke")&&l.getElementsByTagName("stroke")[0],Q=!1;!P&&(Q=P=F("stroke")),(i.stroke&&"none"!=i.stroke||i["stroke-width"]||null!=i["stroke-opacity"]||i["stroke-dasharray"]||i["stroke-miterlimit"]||i["stroke-linejoin"]||i["stroke-linecap"])&&(P.on=!0),("none"==i.stroke||null===i.stroke||null==P.on||0==i.stroke||0==i["stroke-width"])&&(P.on=!1);var R=c.getRGB(i.stroke);P.on&&i.stroke&&(P.color=R.hex),O=((+m["stroke-opacity"]+1||2)-1)*((+m.opacity+1||2)-1)*((+R.o+1||2)-1);var S=.75*(d(i["stroke-width"])||1);if(O=h(g(O,0),1),null==i["stroke-width"]&&(S=m["stroke-width"]),i["stroke-width"]&&(P.weight=S),S&&1>S&&(O*=S)&&(P.weight=1),P.opacity=O,i["stroke-linejoin"]&&(P.joinstyle=i["stroke-linejoin"]||"miter"),P.miterlimit=i["stroke-miterlimit"]||8,i["stroke-linecap"]&&(P.endcap="butt"==i["stroke-linecap"]?"flat":"square"==i["stroke-linecap"]?"square":"round"),"stroke-dasharray"in i){var T={"-":"shortdash",".":"shortdot","-.":"shortdashdot","-..":"shortdashdotdot",". ":"dot","- ":"dash","--":"longdash","- .":"dashdot","--.":"longdashdot","--..":"longdashdotdot"};P.dashstyle=T[a](i["stroke-dasharray"])?T[i["stroke-dasharray"]]:o}Q&&l.appendChild(P)}if("text"==s.type){s.paper.canvas.style.display=o;var U=s.paper.span,V=100,W=m.font&&m.font.match(/\d+(?:\.\d*)?(?=px)/);p=U.style,m.font&&(p.font=m.font),m["font-family"]&&(p.fontFamily=m["font-family"]),m["font-weight"]&&(p.fontWeight=m["font-weight"]),m["font-style"]&&(p.fontStyle=m["font-style"]),W=d(m["font-size"]||W&&W[0])||10,p.fontSize=W*V+"px",s.textpath.string&&(U.innerHTML=b(s.textpath.string).replace(/</g,"&#60;").replace(/&/g,"&#38;").replace(/\n/g,"<br>"));var X=U.getBoundingClientRect();s.W=m.w=(X.right-X.left)/V,s.H=m.h=(X.bottom-X.top)/V,s.X=m.x,s.Y=m.y+s.H/2,("x"in i||"y"in i)&&(s.path.v=c.format("m{0},{1}l{2},{1}",f(m.x*u),f(m.y*u),f(m.x*u)+1));for(var Y=["x","y","text","font","font-family","font-weight","font-style","font-size"],Z=0,$=Y.length;$>Z;Z++)if(Y[Z]in i){s._.dirty=1;break}switch(m["text-anchor"]){case"start":s.textpath.style["v-text-align"]="left",s.bbx=s.W/2;break;case"end":s.textpath.style["v-text-align"]="right",s.bbx=-s.W/2;break;default:s.textpath.style["v-text-align"]="center",s.bbx=0}s.textpath.style["v-text-kern"]=!0}},C=function(a,f,g){a.attrs=a.attrs||{};var h=(a.attrs,Math.pow),i="linear",j=".5 .5";if(a.attrs.gradient=f,f=b(f).replace(c._radial_gradient,function(a,b,c){return i="radial",b&&c&&(b=d(b),c=d(c),h(b-.5,2)+h(c-.5,2)>.25&&(c=e.sqrt(.25-h(b-.5,2))*(2*(c>.5)-1)+.5),j=b+n+c),o}),f=f.split(/\s*\-\s*/),"linear"==i){var k=f.shift();if(k=-d(k),isNaN(k))return null}var l=c._parseDots(f);if(!l)return null;if(a=a.shape||a.node,l.length){a.removeChild(g),g.on=!0,g.method="none",g.color=l[0].color,g.color2=l[l.length-1].color;for(var m=[],p=0,q=l.length;q>p;p++)l[p].offset&&m.push(l[p].offset+n+l[p].color);g.colors=m.length?m.join():"0% "+g.color,"radial"==i?(g.type="gradientTitle",g.focus="100%",g.focussize="0 0",g.focusposition=j,g.angle=0):(g.type="gradient",g.angle=(270-k)%360),a.appendChild(g)}return 1},D=function(a,b){this[0]=this.node=a,a.raphael=!0,this.id=c._oid++,a.raphaelid=this.id,this.X=0,this.Y=0,this.attrs={},this.paper=b,this.matrix=c.matrix(),this._={transform:[],sx:1,sy:1,dx:0,dy:0,deg:0,dirty:1,dirtyT:1},!b.bottom&&(b.bottom=this),this.prev=b.top,b.top&&(b.top.next=this),b.top=this,this.next=null},E=c.el;D.prototype=E,E.constructor=D,E.transform=function(a){if(null==a)return this._.transform;var d,e=this.paper._viewBoxShift,f=e?"s"+[e.scale,e.scale]+"-1-1t"+[e.dx,e.dy]:o;e&&(d=a=b(a).replace(/\.{3}|\u2026/g,this._.transform||o)),c._extractTransform(this,f+a);var g,h=this.matrix.clone(),i=this.skew,j=this.node,k=~b(this.attrs.fill).indexOf("-"),l=!b(this.attrs.fill).indexOf("url(");if(h.translate(1,1),l||k||"image"==this.type)if(i.matrix="1 0 0 1",i.offset="0 0",g=h.split(),k&&g.noRotation||!g.isSimple){j.style.filter=h.toFilter();var m=this.getBBox(),p=this.getBBox(1),q=m.x-p.x,r=m.y-p.y;j.coordorigin=q*-u+n+r*-u,z(this,1,1,q,r,0)}else j.style.filter=o,z(this,g.scalex,g.scaley,g.dx,g.dy,g.rotate);else j.style.filter=o,i.matrix=b(h),i.offset=h.offset();return null!==d&&(this._.transform=d,c._extractTransform(this,d)),this},E.rotate=function(a,c,e){if(this.removed)return this;if(null!=a){if(a=b(a).split(k),a.length-1&&(c=d(a[1]),e=d(a[2])),a=d(a[0]),null==e&&(c=e),null==c||null==e){var f=this.getBBox(1);c=f.x+f.width/2,e=f.y+f.height/2}return this._.dirtyT=1,this.transform(this._.transform.concat([["r",a,c,e]])),this}},E.translate=function(a,c){return this.removed?this:(a=b(a).split(k),a.length-1&&(c=d(a[1])),a=d(a[0])||0,c=+c||0,this._.bbox&&(this._.bbox.x+=a,this._.bbox.y+=c),this.transform(this._.transform.concat([["t",a,c]])),this)},E.scale=function(a,c,e,f){if(this.removed)return this;if(a=b(a).split(k),a.length-1&&(c=d(a[1]),e=d(a[2]),f=d(a[3]),isNaN(e)&&(e=null),isNaN(f)&&(f=null)),a=d(a[0]),null==c&&(c=a),null==f&&(e=f),null==e||null==f)var g=this.getBBox(1);return e=null==e?g.x+g.width/2:e,f=null==f?g.y+g.height/2:f,this.transform(this._.transform.concat([["s",a,c,e,f]])),this._.dirtyT=1,this},E.hide=function(){return!this.removed&&(this.node.style.display="none"),this},E.show=function(){return!this.removed&&(this.node.style.display=o),this},E.auxGetBBox=c.el.getBBox,E.getBBox=function(){var a=this.auxGetBBox();if(this.paper&&this.paper._viewBoxShift){var b={},c=1/this.paper._viewBoxShift.scale;return b.x=a.x-this.paper._viewBoxShift.dx,b.x*=c,b.y=a.y-this.paper._viewBoxShift.dy,b.y*=c,b.width=a.width*c,b.height=a.height*c,b.x2=b.x+b.width,b.y2=b.y+b.height,b}return a},E._getBBox=function(){return this.removed?{}:{x:this.X+(this.bbx||0)-this.W/2,y:this.Y-this.H,width:this.W,height:this.H}},E.remove=function(){if(!this.removed&&this.node.parentNode){this.paper.__set__&&this.paper.__set__.exclude(this),c.eve.unbind("raphael.*.*."+this.id),c._tear(this,this.paper),this.node.parentNode.removeChild(this.node),this.shape&&this.shape.parentNode.removeChild(this.shape);for(var a in this)this[a]="function"==typeof this[a]?c._removedFactory(a):null;this.removed=!0}},E.attr=function(b,d){if(this.removed)return this;if(null==b){var e={};for(var f in this.attrs)this.attrs[a](f)&&(e[f]=this.attrs[f]);return e.gradient&&"none"==e.fill&&(e.fill=e.gradient)&&delete e.gradient,e.transform=this._.transform,e}if(null==d&&c.is(b,"string")){if(b==j&&"none"==this.attrs.fill&&this.attrs.gradient)return this.attrs.gradient;for(var g=b.split(k),h={},i=0,m=g.length;m>i;i++)b=g[i],h[b]=b in this.attrs?this.attrs[b]:c.is(this.paper.customAttributes[b],"function")?this.paper.customAttributes[b].def:c._availableAttrs[b];return m-1?h:h[g[0]]}if(this.attrs&&null==d&&c.is(b,"array")){for(h={},i=0,m=b.length;m>i;i++)h[b[i]]=this.attr(b[i]);return h}var n;null!=d&&(n={},n[b]=d),null==d&&c.is(b,"object")&&(n=b);for(var o in n)l("raphael.attr."+o+"."+this.id,this,n[o]);if(n){for(o in this.paper.customAttributes)if(this.paper.customAttributes[a](o)&&n[a](o)&&c.is(this.paper.customAttributes[o],"function")){var p=this.paper.customAttributes[o].apply(this,[].concat(n[o]));this.attrs[o]=n[o];for(var q in p)p[a](q)&&(n[q]=p[q])}n.text&&"text"==this.type&&(this.textpath.string=n.text),B(this,n)}return this},E.toFront=function(){return!this.removed&&this.node.parentNode.appendChild(this.node),this.paper&&this.paper.top!=this&&c._tofront(this,this.paper),this},E.toBack=function(){return this.removed?this:(this.node.parentNode.firstChild!=this.node&&(this.node.parentNode.insertBefore(this.node,this.node.parentNode.firstChild),c._toback(this,this.paper)),this)},E.insertAfter=function(a){return this.removed?this:(a.constructor==c.st.constructor&&(a=a[a.length-1]),a.node.nextSibling?a.node.parentNode.insertBefore(this.node,a.node.nextSibling):a.node.parentNode.appendChild(this.node),c._insertafter(this,a,this.paper),this)},E.insertBefore=function(a){return this.removed?this:(a.constructor==c.st.constructor&&(a=a[0]),a.node.parentNode.insertBefore(this.node,a.node),c._insertbefore(this,a,this.paper),this)},E.blur=function(a){var b=this.node.runtimeStyle,d=b.filter;return d=d.replace(r,o),0!==+a?(this.attrs.blur=a,b.filter=d+n+m+".Blur(pixelradius="+(+a||1.5)+")",b.margin=c.format("-{0}px 0 0 -{0}px",f(+a||1.5))):(b.filter=d,b.margin=0,delete this.attrs.blur),this},c._engine.path=function(a,b){var c=F("shape");c.style.cssText=t,c.coordsize=u+n+u,c.coordorigin=b.coordorigin;var d=new D(c,b),e={fill:"none",stroke:"#000"};a&&(e.path=a),d.type="path",d.path=[],d.Path=o,B(d,e),b.canvas.appendChild(c);var f=F("skew");return f.on=!0,c.appendChild(f),d.skew=f,d.transform(o),d},c._engine.rect=function(a,b,d,e,f,g){var h=c._rectPath(b,d,e,f,g),i=a.path(h),j=i.attrs;return i.X=j.x=b,i.Y=j.y=d,i.W=j.width=e,i.H=j.height=f,j.r=g,j.path=h,i.type="rect",i},c._engine.ellipse=function(a,b,c,d,e){{var f=a.path();f.attrs}return f.X=b-d,f.Y=c-e,f.W=2*d,f.H=2*e,f.type="ellipse",B(f,{cx:b,cy:c,rx:d,ry:e}),f},c._engine.circle=function(a,b,c,d){{var e=a.path();e.attrs}return e.X=b-d,e.Y=c-d,e.W=e.H=2*d,e.type="circle",B(e,{cx:b,cy:c,r:d}),e},c._engine.image=function(a,b,d,e,f,g){var h=c._rectPath(d,e,f,g),i=a.path(h).attr({stroke:"none"}),k=i.attrs,l=i.node,m=l.getElementsByTagName(j)[0];return k.src=b,i.X=k.x=d,i.Y=k.y=e,i.W=k.width=f,i.H=k.height=g,k.path=h,i.type="image",m.parentNode==l&&l.removeChild(m),m.rotate=!0,m.src=b,m.type="tile",i._.fillpos=[d,e],i._.fillsize=[f,g],l.appendChild(m),z(i,1,1,0,0,0),i},c._engine.text=function(a,d,e,g){var h=F("shape"),i=F("path"),j=F("textpath");d=d||0,e=e||0,g=g||"",i.v=c.format("m{0},{1}l{2},{1}",f(d*u),f(e*u),f(d*u)+1),i.textpathok=!0,j.string=b(g),j.on=!0,h.style.cssText=t,h.coordsize=u+n+u,h.coordorigin="0 0";var k=new D(h,a),l={fill:"#000",stroke:"none",font:c._availableAttrs.font,text:g};k.shape=h,k.path=i,k.textpath=j,k.type="text",k.attrs.text=b(g),k.attrs.x=d,k.attrs.y=e,k.attrs.w=1,k.attrs.h=1,B(k,l),h.appendChild(j),h.appendChild(i),a.canvas.appendChild(h);var m=F("skew");return m.on=!0,h.appendChild(m),k.skew=m,k.transform(o),k},c._engine.setSize=function(a,b){var d=this.canvas.style;return this.width=a,this.height=b,a==+a&&(a+="px"),b==+b&&(b+="px"),d.width=a,d.height=b,d.clip="rect(0 "+a+" "+b+" 0)",this._viewBox&&c._engine.setViewBox.apply(this,this._viewBox),this},c._engine.setViewBox=function(a,b,d,e,f){c.eve("raphael.setViewBox",this,this._viewBox,[a,b,d,e,f]);var g,h,i=this.getSize(),j=i.width,k=i.height;return f&&(g=k/e,h=j/d,j>d*g&&(a-=(j-d*g)/2/g),k>e*h&&(b-=(k-e*h)/2/h)),this._viewBox=[a,b,d,e,!!f],this._viewBoxShift={dx:-a,dy:-b,scale:i},this.forEach(function(a){a.transform("...")}),this};var F;c._engine.initWin=function(a){var b=a.document;b.styleSheets.length<31?b.createStyleSheet().addRule(".rvml","behavior:url(#default#VML)"):b.styleSheets[0].addRule(".rvml","behavior:url(#default#VML)");try{!b.namespaces.rvml&&b.namespaces.add("rvml","urn:schemas-microsoft-com:vml"),F=function(a){return b.createElement("<rvml:"+a+' class="rvml">')}}catch(c){F=function(a){return b.createElement("<"+a+' xmlns="urn:schemas-microsoft.com:vml" class="rvml">')}}},c._engine.initWin(c._g.win),c._engine.create=function(){var a=c._getContainer.apply(0,arguments),b=a.container,d=a.height,e=a.width,f=a.x,g=a.y;if(!b)throw new Error("VML container not found.");var h=new c._Paper,i=h.canvas=c._g.doc.createElement("div"),j=i.style;return f=f||0,g=g||0,e=e||512,d=d||342,h.width=e,h.height=d,e==+e&&(e+="px"),d==+d&&(d+="px"),h.coordsize=1e3*u+n+1e3*u,h.coordorigin="0 0",h.span=c._g.doc.createElement("span"),h.span.style.cssText="position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;",i.appendChild(h.span),j.cssText=c.format("top:0;left:0;width:{0};height:{1};display:inline-block;position:relative;clip:rect(0 {0} {1} 0);overflow:hidden",e,d),1==b?(c._g.doc.body.appendChild(i),j.left=f+"px",j.top=g+"px",j.position="absolute"):b.firstChild?b.insertBefore(i,b.firstChild):b.appendChild(i),h.renderfix=function(){},h},c.prototype.clear=function(){c.eve("raphael.clear",this),this.canvas.innerHTML=o,this.span=c._g.doc.createElement("span"),this.span.style.cssText="position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;display:inline;",this.canvas.appendChild(this.span),this.bottom=this.top=null},c.prototype.remove=function(){c.eve("raphael.remove",this),this.canvas.parentNode.removeChild(this.canvas);for(var a in this)this[a]="function"==typeof this[a]?c._removedFactory(a):null;return!0};var G=c.st;for(var H in E)E[a](H)&&!G[a](H)&&(G[H]=function(a){return function(){var b=arguments;return this.forEach(function(c){c[a].apply(c,b)})}}(H))}}(),B.was?A.win.Raphael=c:Raphael=c,"object"==typeof exports&&(module.exports=c),c});
/**
*
* Jquery Mapael - Dynamic maps jQuery plugin (based on raphael.js)
* Requires jQuery and raphael.js
*
* Version: 1.1.0
*
* Copyright (c) 2015 Vincent Brouté (http://www.vincentbroute.fr/mapael)
* Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
*
*/
(function($) {

	"use strict";
	

	$.fn.mapael = function(options) {
	
		// Extend legend default options with user options
		options = $.extend(true, {}, $.fn.mapael.defaultOptions, options);
		
		for (var type in options.legend) {
			if ($.isArray(options.legend[type])) {
				for (var i = 0; i < options.legend[type].length; ++i)
					options.legend[type][i] = $.extend(true, {}, $.fn.mapael.legendDefaultOptions[type], options.legend[type][i]);
			} else {
				options.legend[type] = $.extend(true, {}, $.fn.mapael.legendDefaultOptions[type], options.legend[type]);
			}
		}
		
		return this.each(function() {
		
			var $self = $(this)
				, $container = $("." + options.map.cssClass, this).empty()
				, $tooltip = $("<div>").addClass(options.map.tooltip.cssClass).css("display", "none").appendTo(options.map.tooltip.target || $container)
				, mapConf = $.fn.mapael.maps[options.map.name]
				, paper = new Raphael($container[0], mapConf.width, mapConf.height)
				, elemOptions = {}
				, resizeTO = 0
				, areas = {}
				, plots = {}
				, links = {}
				, legends = []
				, id = 0
				, zoomCenterX = 0
				, zoomCenterY = 0
				, previousPinchDist = 0;
			
			options.map.tooltip.css && $tooltip.css(options.map.tooltip.css);
			paper.setViewBox(0, 0, mapConf.width, mapConf.height, false);
			
			// Draw map areas
			for (id in mapConf.elems) {
				elemOptions = $.fn.mapael.getElemOptions(
					options.map.defaultArea
					, (options.areas[id] ? options.areas[id] : {})
					, options.legend.area
				);
				areas[id] = {"mapElem" : paper.path(mapConf.elems[id]).attr(elemOptions.attrs)};
			}

			// Hook that allows to add custom processing on the map
			options.map.beforeInit && options.map.beforeInit($self, paper, options);
			
			// Init map areas in a second loop (prevent texts to be hidden by map elements)
			for (id in mapConf.elems) {
				elemOptions = $.fn.mapael.getElemOptions(
					options.map.defaultArea
					, (options.areas[id] ? options.areas[id] : {})
					, options.legend.area
				);
				$.fn.mapael.initElem(paper, areas[id], elemOptions, $tooltip, id);
			}

			// Draw links
			links = $.fn.mapael.drawLinksCollection(paper, options, options.links, mapConf.getCoords, $tooltip);

			// Draw plots
			for (id in options.plots) {
				plots[id] = $.fn.mapael.drawPlot(id, options, mapConf, paper, $tooltip);
			}

			/**
			* Zoom on the map at a specific level focused on specific coordinates
			* If no coordinates are specified, the zoom will be focused on the center of the map
			* options :
			*	"level" : level of the zoom between 0 and maxLevel
			*	"x" or "latitude" : x coordinate or latitude of the point to focus on
			*	"y" or "longitude" : y coordinate or longitude of the point to focus on
			*	"fixedCenter" : set to true in order to preserve the position of x,y in the canvas when zoomed
			*/
			$self.on("zoom", function(e, zoomOptions) {
				var newLevel = Math.min(Math.max(zoomOptions.level, 0), options.map.zoom.maxLevel)
					, panX = 0
					, panY = 0
					, previousZoomLevel = (1 + $self.data("zoomLevel") * options.map.zoom.step)
					, zoomLevel = (1 + newLevel * options.map.zoom.step)
					, offsetX = 0
					, offsetY = 0
					, coords = {};
				
				if (typeof zoomOptions.latitude != "undefined" && typeof zoomOptions.longitude != "undefined") {
					coords = mapConf.getCoords(zoomOptions.latitude, zoomOptions.longitude);
					zoomOptions.x = coords.x;
					zoomOptions.y = coords.y;
				}
				
				if (typeof zoomOptions.x == "undefined")
					zoomOptions.x = paper._viewBox[0] + paper._viewBox[2] / 2;

				if (typeof zoomOptions.y == "undefined")
					zoomOptions.y = (paper._viewBox[1] + paper._viewBox[3] / 2);

				if (newLevel == 0) {
					panX = 0;
					panY = 0;
				} else if (typeof zoomOptions.fixedCenter != 'undefined' && zoomOptions.fixedCenter == true) {
					offsetX = $self.data("panX") + ((zoomOptions.x - $self.data("panX")) * (zoomLevel - previousZoomLevel)) / zoomLevel;
					offsetY = $self.data("panY") + ((zoomOptions.y - $self.data("panY")) * (zoomLevel - previousZoomLevel)) / zoomLevel;
				
					panX = Math.min(Math.max(0, offsetX), (mapConf.width - (mapConf.width / zoomLevel)));
					panY = Math.min(Math.max(0, offsetY), (mapConf.height - (mapConf.height / zoomLevel)));
				} else {
					panX = Math.min(Math.max(0, zoomOptions.x - (mapConf.width / zoomLevel)/2), (mapConf.width - (mapConf.width / zoomLevel)));
					panY = Math.min(Math.max(0, zoomOptions.y - (mapConf.height / zoomLevel)/2), (mapConf.height - (mapConf.height / zoomLevel)));
				}

				// Update zoom level of the map
				if (zoomLevel == previousZoomLevel && panX == $self.data('panX') && panY == $self.data('panY')) return;

				if (options.map.zoom.animDuration > 0) {
					$.fn.mapael.animateViewBox($container, paper, panX, panY, mapConf.width / zoomLevel, mapConf.height / zoomLevel, options.map.zoom.animDuration, options.map.zoom.animEasing);
				} else {
					paper.setViewBox(panX, panY, mapConf.width / zoomLevel, mapConf.height / zoomLevel);
					clearTimeout($.fn.mapael.zoomTO);
					$.fn.mapael.zoomTO = setTimeout(function(){$container.trigger("afterZoom", {x1 : panX, y1 : panY, x2 : (panX+(mapConf.width / zoomLevel)), y2 : (panY+(mapConf.height / zoomLevel))});}, 150);
				}

				$self.data({"zoomLevel" : newLevel, "panX" : panX, "panY" : panY, "zoomX" : zoomOptions.x, "zoomY" : zoomOptions.y});
			});
			
			/**
			* Update the zoom level of the map on mousewheel
			*/
			options.map.zoom.enabled && options.map.zoom.mousewheel && $self.on("mousewheel", function(e) {
				var offset = $container.offset(),
					initFactor = (options.map.width) ? ($.fn.mapael.maps[options.map.name].width / options.map.width) : ($.fn.mapael.maps[options.map.name].width / $container.width())
					, zoomLevel = (e.deltaY > 0) ? 1 : -1
					, zoomFactor = 1 / (1 + ($self.data("zoomLevel")) * options.map.zoom.step)
					, x = zoomFactor * initFactor * (e.clientX + $(window).scrollLeft() - offset.left) + $self.data("panX")
					, y = zoomFactor * initFactor * (e.clientY + $(window).scrollTop() - offset.top) + $self.data("panY");

				$self.trigger("zoom", {"fixedCenter" : true, "level" : $self.data("zoomLevel") + zoomLevel, "x" : x, "y" : y});
					
				return false;
			});

			/**
			* Update the zoom level of the map on touch pinch
			*/
			options.map.zoom.enabled && options.map.zoom.touch && $self.on("touchstart", function(e) {
				if (e.originalEvent.touches.length === 2) {
					zoomCenterX = (e.originalEvent.touches[0].clientX + e.originalEvent.touches[1].clientX) / 2;
					zoomCenterY = (e.originalEvent.touches[0].clientY + e.originalEvent.touches[1].clientY) / 2;
					previousPinchDist = Math.sqrt(Math.pow((e.originalEvent.touches[1].clientX - e.originalEvent.touches[0].clientX), 2) + Math.pow((e.originalEvent.touches[1].clientY - e.originalEvent.touches[0].clientY), 2));
				}
			});

			options.map.zoom.enabled && options.map.zoom.touch && $self.on("touchmove", function(e) {
				var offset = 0, initFactor = 0, zoomFactor = 0, x = 0, y = 0, pinchDist = 0, zoomLevel = 0;

				if (e.originalEvent.touches.length === 2) {
					pinchDist = Math.sqrt(Math.pow((e.originalEvent.touches[1].clientX - e.originalEvent.touches[0].clientX), 2) + Math.pow((e.originalEvent.touches[1].clientY - e.originalEvent.touches[0].clientY), 2));

					if (Math.abs(pinchDist - previousPinchDist) > 15) {
						offset = $container.offset();
						initFactor = (options.map.width) ? ($.fn.mapael.maps[options.map.name].width / options.map.width) : ($.fn.mapael.maps[options.map.name].width / $container.width());
						zoomFactor = 1 / (1 + ($self.data("zoomLevel")) * options.map.zoom.step);
						x = zoomFactor * initFactor * (zoomCenterX + $(window).scrollLeft() - offset.left) + $self.data("panX");
						y = zoomFactor * initFactor * (zoomCenterY + $(window).scrollTop() - offset.top) + $self.data("panY");

						zoomLevel = (pinchDist - previousPinchDist) / Math.abs(pinchDist - previousPinchDist);
						$self.trigger("zoom", {"fixedCenter" : true, "level" : $self.data("zoomLevel") + zoomLevel, "x" : x, "y" : y});
						previousPinchDist = pinchDist;
					}
					return false;
				}
			});

			// Enable zoom
			if (options.map.zoom.enabled)
				$.fn.mapael.initZoom($container, paper, mapConf.width, mapConf.height, options.map.zoom);
			
			// Set initial zoom
			if (typeof options.map.zoom.init != "undefined") {
				$self.trigger("zoom", options.map.zoom.init);
			}
			
			// Create the legends for areas
			$.merge(legends, $.fn.mapael.createLegends($self, options, "area", areas, 1));
				
			/**
			*
			* Update the current map
			* Refresh attributes and tooltips for areas and plots
			* @param updatedOptions options to update for plots and areas
			* @param newPlots new plots to add to the map
			* @param deletedPlotsplots to delete from the map
			* @param opt option for the refresh :
			*  opt.animDuration animation duration in ms (default = 0)
			*  opt.resetAreas true to reset previous areas options
			*  opt.resetPlots true to reset previous plots options
			*  opt.resetLinks true to reset previous links options
			*  opt.afterUpdate Hook that allows to add custom processing on the map
			*  opt.newLinks new links to add to the map
			*  opt.deletedLinks links to remove from the map
			*/
			$self.on("update", function(e, updatedOptions, newPlots, deletedPlots, opt) {
				var i = 0
					, id = 0
					, animDuration = 0
					, elemOptions = {};
				
				// Reset hidden map elements (when user click on legend elements)
				legends.forEach(function(el) {
					el.forEach && el.forEach(function(el) {
						if(typeof el.hidden != "undefined" && el.hidden == true) {
							$(el.node).trigger("click");
						}
					})
				});
				
				if (typeof opt != "undefined") {
					(opt.resetAreas) && (options.areas = {});
					(opt.resetPlots) && (options.plots = {});
					(opt.resetLinks) && (options.links = {});
					(opt.animDuration) && (animDuration = opt.animDuration);
				}
				
				$.extend(true, options, updatedOptions);

				// Delete plots
				if (typeof deletedPlots == "object") {
					for (;i < deletedPlots.length; i++) {
						if (typeof plots[deletedPlots[i]] != "undefined") {
							if (animDuration > 0) {
								(function(plot) {
									plot.mapElem.animate({"opacity":0}, animDuration, "linear", function() {plot.mapElem.remove();});
									if (plot.textElem) {
										plot.textElem.animate({"opacity":0}, animDuration, "linear", function() {plot.textElem.remove();});
									}
								})(plots[deletedPlots[i]]);
							} else {
								plots[deletedPlots[i]].mapElem.remove();
								if (plots[deletedPlots[i]].textElem) {
									plots[deletedPlots[i]].textElem.remove();
								}
							}
							delete plots[deletedPlots[i]];
						}
					}
				}

				// Delete links
				if (typeof opt != "undefined" && typeof opt.deletedLinks == "object") {
					for (i = 0;i < opt.deletedLinks.length; i++) {
						if (typeof links[opt.deletedLinks[i]] != "undefined") {
							if (animDuration > 0) {
								(function(plot) {
									plot.mapElem.animate({"opacity":0}, animDuration, "linear", function() {plot.mapElem.remove();});
									if (plot.textElem) {
										plot.textElem.animate({"opacity":0}, animDuration, "linear", function() {plot.textElem.remove();});
									}
								})(links[opt.deletedLinks[i]]);
							} else {
								links[opt.deletedLinks[i]].mapElem.remove();
								if (links[opt.deletedLinks[i]].textElem) {
									links[opt.deletedLinks[i]].textElem.remove();
								}
							}
							delete links[opt.deletedLinks[i]];
						}
					}
				}
				
				// New plots
				if (typeof newPlots == "object") {
					for (id in newPlots) {
						if (typeof plots[id] == "undefined") {
							options.plots[id] = newPlots[id];
							plots[id] = $.fn.mapael.drawPlot(id, options, mapConf, paper, $tooltip);
							if (animDuration > 0) {
								plots[id].mapElem.attr({opacity : 0});
								plots[id].mapElem.animate({"opacity": (typeof plots[id].mapElem.originalAttrs.opacity != "undefined") ? plots[id].mapElem.originalAttrs.opacity : 1}, animDuration);
								
								if (plots[id].textElem) {
									plots[id].textElem.attr({opacity : 0});
									plots[id].textElem.animate({"opacity": (typeof plots[id].textElem.originalAttrs.opacity != "undefined") ? plots[id].textElem.originalAttrs.opacity : 1}, animDuration);
								}
							}
						}
					}
				}

				// New links
				if (typeof opt != "undefined" && typeof opt.newLinks == "object") {
					var newLinks = $.fn.mapael.drawLinksCollection(paper, options, opt.newLinks, mapConf.getCoords, $tooltip);
					$.extend(links);
					if (animDuration > 0) {
						for (id in newLinks) {
							newLinks[id].mapElem.attr({opacity : 0});
							newLinks[id].mapElem.animate({"opacity": (typeof newLinks[id].mapElem.originalAttrs.opacity != "undefined") ? newLinks[id].mapElem.originalAttrs.opacity : 1}, animDuration);

							if (newLinks[id].textElem) {
								newLinks[id].textElem.attr({opacity : 0});
								newLinks[id].textElem.animate({"opacity": (typeof newLinks[id].textElem.originalAttrs.opacity != "undefined") ? newLinks[id].textElem.originalAttrs.opacity : 1}, animDuration);
							}
						}
					}
				}

				// Update areas attributes and tooltips
				for (id in areas) {
					elemOptions = $.fn.mapael.getElemOptions(
						options.map.defaultArea
						, (options.areas[id] ? options.areas[id] : {})
						, options.legend.area
					);
					
					$.fn.mapael.updateElem(elemOptions, areas[id], $tooltip, animDuration);
				}
				
				// Update plots attributes and tooltips
				for (id in plots) {
					elemOptions = $.fn.mapael.getElemOptions(
						options.map.defaultPlot
						, (options.plots[id] ? options.plots[id] : {})
						, options.legend.plot
					);
					if (elemOptions.type == "square") {
						elemOptions.attrs.width = elemOptions.size;
						elemOptions.attrs.height = elemOptions.size;
						elemOptions.attrs.x = plots[id].mapElem.attrs.x - (elemOptions.size - plots[id].mapElem.attrs.width) / 2;
						elemOptions.attrs.y = plots[id].mapElem.attrs.y - (elemOptions.size - plots[id].mapElem.attrs.height) / 2;
					} else if (elemOptions.type == "image") {
						elemOptions.attrs.width = elemOptions.width;
						elemOptions.attrs.height = elemOptions.height;
						elemOptions.attrs.x = plots[id].mapElem.attrs.x - (elemOptions.width - plots[id].mapElem.attrs.width) / 2;
						elemOptions.attrs.y = plots[id].mapElem.attrs.y - (elemOptions.height - plots[id].mapElem.attrs.height) / 2;
					} else { // Default : circle
						elemOptions.attrs.r = elemOptions.size / 2;
					}
					
					$.fn.mapael.updateElem(elemOptions, plots[id], $tooltip, animDuration);
				}

				// Update links attributes and tooltips
				for (id in links) {
					elemOptions = $.fn.mapael.getElemOptions(
						options.map.defaultLink
						, (options.links[id] ? options.links[id] : {})
						, {}
					);
					
					$.fn.mapael.updateElem(elemOptions, links[id], $tooltip, animDuration);
				}
				
				if(typeof opt != "undefined")
					opt.afterUpdate && opt.afterUpdate($self, paper, areas, plots, options);
			});
			
			// Handle resizing of the map
			if (options.map.width) {
				paper.setSize(options.map.width, mapConf.height * (options.map.width / mapConf.width));
				
				// Create the legends for plots taking into account the scale of the map
				$.merge(legends, $.fn.mapael.createLegends($self, options, "plot", plots, (options.map.width / mapConf.width)));
			} else {
				$(window).on("resize", function() {
					clearTimeout(resizeTO);
					resizeTO = setTimeout(function(){$container.trigger("resizeEnd");}, 150);
				});
				
				// Create the legends for plots taking into account the scale of the map
				var createPlotLegend = function() {
					$.merge(legends, $.fn.mapael.createLegends($self, options, "plot", plots, ($container.width() / mapConf.width)));
					
					$container.unbind("resizeEnd", createPlotLegend);
				};
				
				$container.on("resizeEnd", function() {
					var containerWidth = $container.width();
					if (paper.width != containerWidth) {
						paper.setSize(containerWidth, mapConf.height * (containerWidth / mapConf.width));
					}
				}).on("resizeEnd", createPlotLegend).trigger("resizeEnd");
			}
			
			// Hook that allows to add custom processing on the map
			options.map.afterInit && options.map.afterInit($self, paper, areas, plots, options);
			
			$(paper.desc).append(" and Mapael (http://www.vincentbroute.fr/mapael/)");
		});
	};

	$.fn.mapael.zoomTO = 0;
	
	/**
	* Init the element "elem" on the map (drawing, setting attributes, events, tooltip, ...)
	*/
	$.fn.mapael.initElem = function(paper, elem, options, $tooltip, id) {
		var bbox = {}, textPosition = {};
		if (typeof options.value != "undefined")
			elem.value = options.value;
		
		// Init attrsHover
		$.fn.mapael.setHoverOptions(elem.mapElem, options.attrs, options.attrsHover);
		
		// Init the label related to the element
		if (options.text && typeof options.text.content != "undefined") {
			// Set a text label in the area
			bbox = elem.mapElem.getBBox();
			textPosition = $.fn.mapael.getTextPosition(bbox, options.text.position, options.text.margin);
			options.text.attrs["text-anchor"] = textPosition.textAnchor;
			elem.textElem = paper.text(textPosition.x, textPosition.y, options.text.content).attr(options.text.attrs);
			$.fn.mapael.setHoverOptions(elem.textElem, options.text.attrs, options.text.attrsHover);
			options.eventHandlers && $.fn.mapael.setEventHandlers(id, options, elem.mapElem, elem.textElem);
			$.fn.mapael.setHover(paper, elem.mapElem, elem.textElem);
			$(elem.textElem.node).attr("data-id", id);
		} else {
			options.eventHandlers && $.fn.mapael.setEventHandlers(id, options, elem.mapElem);
			$.fn.mapael.setHover(paper, elem.mapElem);
		}
		
		// Init the tooltip
		if (options.tooltip) {
			elem.mapElem.tooltip = options.tooltip;
			$.fn.mapael.setTooltip(elem.mapElem, $tooltip);
			
			if (options.text && typeof options.text.content != "undefined") {
				elem.textElem.tooltip = options.tooltip;
				$.fn.mapael.setTooltip(elem.textElem, $tooltip);
			}
		}
		
		// Init the link
		if (options.href) {
			elem.mapElem.href = options.href;
			elem.mapElem.target = options.target;
			$.fn.mapael.setHref(elem.mapElem);
			
			if (options.text && typeof options.text.content != "undefined") {
				elem.textElem.href = options.href;
				elem.textElem.target = options.target;
				$.fn.mapael.setHref(elem.textElem);
			}
		}
		
		$(elem.mapElem.node).attr("data-id", id);
	};
	
	/**
	* Draw all links between plots on the paper
	*/
	$.fn.mapael.drawLinksCollection = function(paper, options, linksCollection, getCoords, $tooltip) {
		var p1 = {}
			, p2 = {}
			, elemOptions = {}
			, coordsP1 = {}
			, coordsP2 ={}
			, links = {};

		for (var id in linksCollection) {
			elemOptions = $.fn.mapael.getElemOptions(options.map.defaultLink, linksCollection[id], {});
			
			if (typeof linksCollection[id].between[0] == 'string') {
				p1 = options.plots[linksCollection[id].between[0]];
			} else {
				p1 = linksCollection[id].between[0];
			}

			if (typeof linksCollection[id].between[1] == 'string') {
				p2 = options.plots[linksCollection[id].between[1]];
			} else {
				p2 = linksCollection[id].between[1];
			}

			if (typeof p1.latitude != "undefined" && typeof p1.longitude != "undefined") {
				coordsP1 = getCoords(p1.latitude, p1.longitude);
			} else {
				coordsP1.x = p1.x;
				coordsP1.y = p1.y;
			}

			if (typeof p2.latitude != "undefined" && typeof p2.longitude != "undefined") {
				coordsP2 = getCoords(p2.latitude, p2.longitude);
			} else {
				coordsP2.x = p2.x;
				coordsP2.y = p2.y;
			}
			links[id] = $.fn.mapael.drawLink(id, paper, coordsP1.x, coordsP1.y, coordsP2.x, coordsP2.y, elemOptions, $tooltip);
		}
		return links;
	};
	
	/**
	* Draw a curved link between two couples of coordinates a(xa,ya) and b(xb, yb) on the paper
	*/
	$.fn.mapael.drawLink = function(id, paper, xa, ya, xb, yb, elemOptions, $tooltip) {
		var elem = {}
		
			// Compute the "curveto" SVG point, d(x,y)
			// c(xc, yc) is the center of (xa,ya) and (xb, yb)
			, xc = (xa + xb) / 2
			 , yc = (ya + yb) / 2
				
			 // Equation for (cd) : y = acd * x + bcd (d is the cure point)
			 , acd = - 1 / ((yb - ya) / (xb - xa))
			 , bcd = yc - acd * xc
		
			 // dist(c,d) = dist(a,b) (=abDist)
			 , abDist = Math.sqrt((xb-xa)*(xb-xa) + (yb-ya)*(yb-ya))

			 // Solution for equation dist(cd) = sqrt((xd - xc)² + (yd - yc)²)
			 // dist(c,d)² = (xd - xc)² + (yd - yc)²
			 // We assume that dist(c,d) = dist(a,b)
			 // so : (xd - xc)² + (yd - yc)² - dist(a,b)² = 0
			 // With the factor : (xd - xc)² + (yd - yc)² - (factor*dist(a,b))² = 0
			 // (xd - xc)² + (acd*xd + bcd - yc)² - (factor*dist(a,b))² = 0
			 , a = 1 + acd*acd
			 , b = -2 * xc + 2*acd*bcd - 2 * acd*yc
			 , c = xc*xc + bcd*bcd - bcd*yc - yc*bcd + yc*yc - ((elemOptions.factor*abDist) * (elemOptions.factor*abDist))
			 , delta = b*b - 4*a*c
			 , x = 0
			 , y = 0;
		
		// There are two solutions, we choose one or the other depending on the sign of the factor
		if (elemOptions.factor > 0) {
			 x = (-b + Math.sqrt(delta)) / (2*a);
			 y = acd * x + bcd;
		} else {
			 x = (-b - Math.sqrt(delta)) / (2*a);
			 y = acd * x + bcd;
		}

		elem.mapElem = paper.path("m "+xa+","+ya+" C "+x+","+y+" "+xb+","+yb+" "+xb+","+yb+"").attr(elemOptions.attrs);
		$.fn.mapael.initElem(paper, elem, elemOptions, $tooltip, id);
		
		return elem;
	};

	/**
	* Update the element "elem" on the map with the new elemOptions options
	*/
	$.fn.mapael.updateElem = function(elemOptions, elem, $tooltip, animDuration) {
		var bbox, textPosition, plotOffsetX, plotOffsetY;
		if (typeof elemOptions.value != "undefined")
			elem.value = elemOptions.value;

		// Update the label
		if (elem.textElem) {
			if (typeof elemOptions.text != "undefined" && typeof elemOptions.text.content != "undefined" && elemOptions.text.content != elem.textElem.attrs.text)
				elem.textElem.attr({text : elemOptions.text.content});

			bbox = elem.mapElem.getBBox();

			if (elemOptions.size || (elemOptions.width && elemOptions.height)) {
				if (elemOptions.type == "image" || elemOptions.type == "svg") {
					plotOffsetX = (elemOptions.width - bbox.width) / 2;
					plotOffsetY = (elemOptions.height - bbox.height) / 2;
				} else {
					plotOffsetX = (elemOptions.size - bbox.width) / 2;
					plotOffsetY = (elemOptions.size - bbox.height) / 2;
				}
				bbox.x -= plotOffsetX;
				bbox.x2 += plotOffsetX;
				bbox.y -= plotOffsetY;
				bbox.y2 += plotOffsetY;
			}

			textPosition = $.fn.mapael.getTextPosition(bbox, elemOptions.text.position, elemOptions.text.margin);
			if (textPosition.x != elem.textElem.attrs.x || textPosition.y != elem.textElem.attrs.y) {
				if (animDuration > 0) {
					elem.textElem.attr({"text-anchor" : textPosition.textAnchor});
					elem.textElem.animate({x : textPosition.x, y : textPosition.y}, animDuration);
				} else
					elem.textElem.attr({x : textPosition.x, y : textPosition.y, "text-anchor" : textPosition.textAnchor});
			}
			
			$.fn.mapael.setHoverOptions(elem.textElem, elemOptions.text.attrs, elemOptions.text.attrsHover);
			if (animDuration > 0)
				elem.textElem.animate(elemOptions.text.attrs, animDuration);
			else
				elem.textElem.attr(elemOptions.text.attrs);
		}
		
		// Update elements attrs and attrsHover
		$.fn.mapael.setHoverOptions(elem.mapElem, elemOptions.attrs, elemOptions.attrsHover);
		if (animDuration > 0)
			elem.mapElem.animate(elemOptions.attrs, animDuration);
		else
			elem.mapElem.attr(elemOptions.attrs);

		// Update dimensions of SVG plots
		if (elemOptions.type == "svg") {
			elem.mapElem.transform("m"+(elemOptions.width / elem.mapElem.originalWidth)+",0,0,"+(elemOptions.height / elem.mapElem.originalHeight)+","+bbox.x+","+bbox.y);
		}

		// Update the tooltip
		if (elemOptions.tooltip) {
			if (typeof elem.mapElem.tooltip == "undefined") {
				$.fn.mapael.setTooltip(elem.mapElem, $tooltip);
				(elem.textElem) && $.fn.mapael.setTooltip(elem.textElem, $tooltip);
			}
			elem.mapElem.tooltip = elemOptions.tooltip;
			(elem.textElem) && (elem.textElem.tooltip = elemOptions.tooltip);
		}
		
		// Update the link
		if (typeof elemOptions.href != "undefined") {
			if (typeof elem.mapElem.href == "undefined") {
				$.fn.mapael.setHref(elem.mapElem);
				(elem.textElem) && $.fn.mapael.setHref(elem.textElem);
			}
			elem.mapElem.href = elemOptions.href;
			elem.mapElem.target = elemOptions.target;
			if (elem.textElem) {
				elem.textElem.href = elemOptions.href;
				elem.textElem.target = elemOptions.target;
			}
		}
	};
	
	/**
	* Draw the plot
	*/
	$.fn.mapael.drawPlot = function(id, options, mapConf, paper, $tooltip) {
		var plot = {}
			, coords = {}
			, elemOptions = $.fn.mapael.getElemOptions(
				options.map.defaultPlot
				, (options.plots[id] ? options.plots[id] : {})
				, options.legend.plot
			);
		
		if (typeof elemOptions.x != "undefined" && typeof elemOptions.y != "undefined")
			coords = {x : elemOptions.x, y : elemOptions.y};
		else
			coords = mapConf.getCoords(elemOptions.latitude, elemOptions.longitude);
		
		if (elemOptions.type == "square") {
			plot = {"mapElem" : paper.rect(
				coords.x - (elemOptions.size / 2)
				, coords.y - (elemOptions.size / 2)
				, elemOptions.size
				, elemOptions.size
			).attr(elemOptions.attrs)};
		} else if (elemOptions.type == "image") {
			plot = {
				"mapElem" : paper.image(
					elemOptions.url
					, coords.x - elemOptions.width / 2
					, coords.y - elemOptions.height / 2
					, elemOptions.width
					, elemOptions.height
				).attr(elemOptions.attrs)
			};
		} else if (elemOptions.type == "svg") {
			plot = {"mapElem" : paper.path(elemOptions.path).attr(elemOptions.attrs)};
			plot.mapElem.originalWidth = plot.mapElem.getBBox().width;
			plot.mapElem.originalHeight = plot.mapElem.getBBox().height;
			plot.mapElem.transform("m"+(elemOptions.width / plot.mapElem.originalWidth)+",0,0,"+(elemOptions.height / plot.mapElem.originalHeight)+","+(coords.x - elemOptions.width / 2)+","+(coords.y - elemOptions.height / 2));
		} else { // Default = circle
			plot = {"mapElem" : paper.circle(coords.x, coords.y, elemOptions.size / 2).attr(elemOptions.attrs)};
		}
		
		$.fn.mapael.initElem(paper, plot, elemOptions, $tooltip, id);
		return plot;
	};
	
	/**
	* Set target link on elem
	*/
	$.fn.mapael.setHref = function(elem) {
		elem.attr({cursor : "pointer"});
		$(elem.node).bind("click", function() {
			if (!$.fn.mapael.panning && elem.href)
				window.open(elem.href, elem.target);
		});
	};
	
	/**
	* Set a tooltip for the areas and plots
	* @param elem area or plot element
	* @param $tooltip the tooltip container
	* @param content the content to set in the tooltip
	*/
	$.fn.mapael.setTooltip = function(elem, $tooltip) {
		var tooltipTO = 0, $container = $tooltip.parent(), cssClass = $tooltip.attr('class');
	
		$(elem.node).on("mouseover", function(e) {
			tooltipTO = setTimeout(
				function() {
					$tooltip.attr("class", cssClass);
					if (typeof elem.tooltip != "undefined") {
						if (typeof elem.tooltip.content != "undefined") {
							$tooltip.html(elem.tooltip.content).css("display", "block");
						}
						if (typeof elem.tooltip.cssClass != "undefined") {
							$tooltip.addClass(elem.tooltip.cssClass);
						} 
					}
					$tooltip.css({
						"left" : Math.min($container.offset().left + $container.width() - $tooltip.outerWidth() - 5, e.pageX + 10) - $(window).scrollLeft(),
						"top" : Math.min($container.offset().top + $container.height() - $tooltip.outerHeight() - 5, e.pageY + 20) - $(window).scrollTop()
					});
				}
				, 120
			);
		}).on("mouseout", function(e) {
			clearTimeout(tooltipTO);
			$tooltip.css("display", "none");
		}).on("mousemove", function(e) {
			$tooltip.css({
				"left" : Math.min($container.offset().left + $container.width() - $tooltip.outerWidth() - 5, e.pageX + 10) - $(window).scrollLeft(),
				"top" : Math.min($container.offset().top + $container.height() - $tooltip.outerHeight() - 5 , e.pageY + 20)- $(window).scrollTop()
			});
		});
	};
	
	/**
	* Set user defined handlers for events on areas and plots
	* @param id the id of the element
	* @param elemOptions the element parameters
	* @param mapElem the map element to set callback on
	* @param textElem the optional text within the map element
	*/
	$.fn.mapael.setEventHandlers = function(id, elemOptions, mapElem, textElem) {
		for(var event in elemOptions.eventHandlers) {
			(function(event) {
				$(mapElem.node).on(event, function(e) {!$.fn.mapael.panning && elemOptions.eventHandlers[event](e, id, mapElem, textElem, elemOptions)});
				textElem && $(textElem.node).on(event, function(e) {!$.fn.mapael.panning && elemOptions.eventHandlers[event](e, id, mapElem, textElem, elemOptions)});
			})(event);
		}
	};
	
	$.fn.mapael.panning = false;
	$.fn.mapael.panningTO = 0;
	
	/**
	* Init zoom and panning for the map
	* @param $container
	* @param paper
	* @param mapWidth
	* @param mapHeight
	* @param options
	*/
	$.fn.mapael.initZoom = function($container, paper, mapWidth, mapHeight, options) {
		var $parentContainer = $container.parent()
			, $zoomIn = $("<div>").addClass(options.zoomInCssClass).html("+")
			, $zoomOut = $("<div>").addClass(options.zoomOutCssClass).html("&#x2212;")
			, mousedown = false
			, previousX = 0
			, previousY = 0;
		
		// Zoom
		$parentContainer.data("zoomLevel", 0).data({"panX" : 0, "panY" : 0});
		$container.append($zoomIn).append($zoomOut);
		
		$zoomIn.on("click", function() {$parentContainer.trigger("zoom", {"level" : $parentContainer.data("zoomLevel") + 1});});
		$zoomOut.on("click", function() {$parentContainer.trigger("zoom", {"level" : $parentContainer.data("zoomLevel") - 1});});
		
		// Panning
		$("body").on("mouseup" + (options.touch ? " touchend" : ""), function(e) {
			mousedown = false;
			setTimeout(function () {$.fn.mapael.panning = false;}, 50);
		});
		
		$container.on("mousedown" + (options.touch ? " touchstart" : ""), function(e) {
			if (typeof e.pageX !== 'undefined') {
				mousedown = true;
				previousX = e.pageX;
				previousY = e.pageY;
			} else {
				if (e.originalEvent.touches.length === 1) {
					mousedown = true;
					previousX = e.originalEvent.touches[0].pageX;
					previousY = e.originalEvent.touches[0].pageY;
				}
			}
		}).on("mousemove" + (options.touch ? " touchmove" : ""), function(e) {
			var currentLevel = $parentContainer.data("zoomLevel")
				, pageX = 0
				, pageY = 0;

			if (typeof e.pageX !== 'undefined') {
				pageX = e.pageX;
				pageY = e.pageY;
			} else {
				if (e.originalEvent.touches.length === 1) {
					pageX = e.originalEvent.touches[0].pageX;
					pageY = e.originalEvent.touches[0].pageY;
				} else {
					mousedown = false;
				}
			}

			if (mousedown && currentLevel != 0) {
				var offsetX = (previousX - pageX) / (1 + (currentLevel * options.step)) * (mapWidth / paper.width)
					, offsetY = (previousY - pageY) / (1 + (currentLevel * options.step)) * (mapHeight / paper.height)
					, panX = Math.min(Math.max(0, paper._viewBox[0] + offsetX), (mapWidth - paper._viewBox[2]))
					, panY = Math.min(Math.max(0, paper._viewBox[1] + offsetY), (mapHeight - paper._viewBox[3]));					
				
				if (Math.abs(offsetX) > 5 || Math.abs(offsetY) > 5) {
					$parentContainer.data({"panX" : panX, "panY" : panY});
					
					paper.setViewBox(panX, panY, paper._viewBox[2], paper._viewBox[3]);

					clearTimeout($.fn.mapael.panningTO);
					$.fn.mapael.panningTO = setTimeout(function(){$container.trigger("afterPanning", {x1 : panX, y1 : panY, x2 : (panX+paper._viewBox[2]), y2 : (panY+paper._viewBox[3])});}, 150);

					previousX = pageX;
					previousY = pageY;
					$.fn.mapael.panning = true;
				}
				return false;
			}
		});
	};
	
	/**
	* Draw a legend for areas and / or plots
	* @param legendOptions options for the legend to draw
	* @param $container the map container
	* @param options map options object
	* @param legendType the type of the legend : "area" or "plot"
	* @param elems collection of plots or areas on the maps
	* @param legendIndex index of the legend in the conf array
	*/
	$.fn.mapael.drawLegend = function (legendOptions, $container, options, legendType, elems, scale, legendIndex) {
		var $legend = {}
			, paper = {}
			, width = 0
			, height = 0
			, title = {}
			, elem = {}
			, elemBBox = {}
			, label = {}
			, i = 0
			, x = 0
			, y = 0
			, yCenter = 0
			, sliceAttrs = []
			, length = 0;
		
			if (!legendOptions.slices || !legendOptions.display)
				return;
				
			$legend = $("." + legendOptions.cssClass, $container).empty();
			paper = new Raphael($legend.get(0));
			height = width = 0;
			
			// Set the title of the legend
			if(legendOptions.title) {
				title = paper.text(legendOptions.marginLeftTitle, 0, legendOptions.title).attr(legendOptions.titleAttrs);
				title.attr({y : 0.5 * title.getBBox().height});
					
				width = legendOptions.marginLeftTitle + title.getBBox().width;
				height += legendOptions.marginBottomTitle + title.getBBox().height;
			}
			
			// Calculate attrs (and width, height and r (radius)) for legend elements, and yCenter for horizontal legends
			for(i = 0, length = legendOptions.slices.length; i < length; ++i) {
				if (typeof legendOptions.slices[i].legendSpecificAttrs == "undefined")
					legendOptions.slices[i].legendSpecificAttrs = {};
					
				sliceAttrs[i] = $.extend(
					{}
					, (legendType == "plot") ? options.map["defaultPlot"].attrs : options.map["defaultArea"].attrs
					, legendOptions.slices[i].attrs
					, legendOptions.slices[i].legendSpecificAttrs
				);
			
				if (legendType == "area") {
					if (typeof sliceAttrs[i].width == "undefined")
						sliceAttrs[i].width = 30;
					if (typeof sliceAttrs[i].height == "undefined")
						sliceAttrs[i].height = 20;
				} else if (legendOptions.slices[i].type == "square") {
					if (typeof sliceAttrs[i].width == "undefined")
						sliceAttrs[i].width = legendOptions.slices[i].size;
					if (typeof sliceAttrs[i].height == "undefined")
						sliceAttrs[i].height = legendOptions.slices[i].size;
				} else if (legendOptions.slices[i].type == "image" || legendOptions.slices[i].type == "svg") {
					if (typeof sliceAttrs[i].width == "undefined")
						sliceAttrs[i].width = legendOptions.slices[i].width;
					if (typeof sliceAttrs[i].height == "undefined")
						sliceAttrs[i].height = legendOptions.slices[i].height;
				} else {
					if (typeof sliceAttrs[i].r == "undefined")
						sliceAttrs[i].r = legendOptions.slices[i].size / 2;
				}
				
				if(legendType == "plot" && (typeof legendOptions.slices[i].type == "undefined" || legendOptions.slices[i].type == "circle")) {
					yCenter = Math.max(yCenter, legendOptions.marginBottomTitle + title.getBBox().height + scale * sliceAttrs[i].r);	
				} else {
					yCenter = Math.max(yCenter, legendOptions.marginBottomTitle + title.getBBox().height + scale * sliceAttrs[i].height/2);
				}
			}
				
			if (legendOptions.mode == "horizontal") {
				width = legendOptions.marginLeft;
			}
			
			// Draw legend elements (circle, square or image in vertical or horizontal mode)
			for(i = 0, length = legendOptions.slices.length; i < length; ++i) {
				if (typeof legendOptions.slices[i].display == "undefined" || legendOptions.slices[i].display == true) {
					if(legendType == "area") {
						if (legendOptions.mode == "horizontal") {
							x = width + legendOptions.marginLeft;
							y = yCenter - (0.5 * scale * sliceAttrs[i].height);
						} else {
							x = legendOptions.marginLeft;
							y = height;
						}
						
						elem = paper.rect(x, y, scale * (sliceAttrs[i].width), scale * (sliceAttrs[i].height));
					} else if(legendOptions.slices[i].type == "square") {					
						if (legendOptions.mode == "horizontal") {
							x = width + legendOptions.marginLeft;
							y = yCenter - (0.5 * scale * sliceAttrs[i].height);
						} else {
							x = legendOptions.marginLeft;
							y = height;
						}
						
						elem = paper.rect(x, y, scale * (sliceAttrs[i].width), scale * (sliceAttrs[i].height));
							
					} else if(legendOptions.slices[i].type == "image" || legendOptions.slices[i].type == "svg") {					
						if (legendOptions.mode == "horizontal") {
							x = width + legendOptions.marginLeft;
							y = yCenter - (0.5 * scale * sliceAttrs[i].height);
						} else {
							x = legendOptions.marginLeft;
							y = height;
						}

						if (legendOptions.slices[i].type == "image") {
							elem = paper.image(
								legendOptions.slices[i].url, x, y, scale * sliceAttrs[i].width, scale * sliceAttrs[i].height);
						} else {
							elem = paper.path(legendOptions.slices[i].path);
							elem.transform("m"+((scale*legendOptions.slices[i].width) / elem.getBBox().width)+",0,0,"+((scale*legendOptions.slices[i].height) / elem.getBBox().height)+","+x+","+y);
						}
					} else {
						if (legendOptions.mode == "horizontal") {
							x = width + legendOptions.marginLeft + scale * (sliceAttrs[i].r);
							y = yCenter;
						} else {
							x = legendOptions.marginLeft + scale * (sliceAttrs[i].r);
							y = height + scale * (sliceAttrs[i].r);
						}
						elem = paper.circle(x, y, scale * (sliceAttrs[i].r));
					}
					
					// Set attrs to the element drawn above
					delete sliceAttrs[i].width;
					delete sliceAttrs[i].height;
					delete sliceAttrs[i].r;
					elem.attr(sliceAttrs[i]);
					elemBBox = elem.getBBox();

					// Draw the label associated with the element
					if (legendOptions.mode == "horizontal") {
						x = width + legendOptions.marginLeft + elemBBox.width + legendOptions.marginLeftLabel;
						y = yCenter;
					} else {
						x = legendOptions.marginLeft + elemBBox.width + legendOptions.marginLeftLabel;
						y = height + (elemBBox.height / 2);
					}
					
					label = paper.text(x, y, legendOptions.slices[i].label).attr(legendOptions.labelAttrs);
					
					// Update the width and height for the paper
					if (legendOptions.mode == "horizontal") {
						width += legendOptions.marginLeft + elemBBox.width + legendOptions.marginLeftLabel + label.getBBox().width;
						if(legendOptions.slices[i].type == "image" || legendType == "area") {
							height = Math.max(height, legendOptions.marginBottom + title.getBBox().height + elemBBox.height);
						} else {
							height = Math.max(height, legendOptions.marginBottomTitle + legendOptions.marginBottom + title.getBBox().height + elemBBox.height);
						}
					} else {
						width = Math.max(width, legendOptions.marginLeft + elemBBox.width + legendOptions.marginLeftLabel + label.getBBox().width);
						height += legendOptions.marginBottom + elemBBox.height;
					}
					
					$(elem.node).attr({"data-type": "elem", "data-index": i, "data-hidden": 0});
					$(label.node).attr({"data-type": "label", "data-index": i, "data-hidden": 0});
					
					// Hide map elements when the user clicks on a legend item
					if (legendOptions.hideElemsOnClick.enabled) {
						// Hide/show elements when user clicks on a legend element
						label.attr({cursor:"pointer"});
						elem.attr({cursor:"pointer"});
						
						$.fn.mapael.setHoverOptions(elem, sliceAttrs[i], sliceAttrs[i]);
						$.fn.mapael.setHoverOptions(label, legendOptions.labelAttrs, legendOptions.labelAttrsHover);
						$.fn.mapael.setHover(paper, elem, label);
						$.fn.mapael.handleClickOnLegendElem($container, legendOptions, legendOptions.slices[i], label, elem, elems, legendIndex);
					}
				}
			}
		
			// VMLWidth option allows you to set static width for the legend
			// only for VML render because text.getBBox() returns wrong values on IE6/7
			if (Raphael.type != "SVG" && legendOptions.VMLWidth)
				width = legendOptions.VMLWidth;
			
			paper.setSize(width, height);
			return paper;
	};
	
	/**
	* Allow to hide elements of the map when the user clicks on a related legend item
	* @param $container the map container
	* @param legendOptions options for the legend to draw
	* @param sliceOptions options of the slice
	* @param label label of the legend item
	* @param elem element of the legend item
	* @param elems collection of plots or areas displayed on the map
	* @param legendIndex index of the legend in the conf array
	*/
	$.fn.mapael.handleClickOnLegendElem = function($container, legendOptions, sliceOptions, label, elem, elems, legendIndex) {
		var hideMapElems = function(e, hideOtherElems) {
			var elemValue = 0
				, hidden = $(label.node).attr('data-hidden')
				, hiddenNewAttr = (hidden == 0) ? {"data-hidden": 1} : {"data-hidden": 0};

			if (hidden == 0) {
				label.animate({"opacity":0.5}, 300);
			} else {
				label.animate({"opacity":1}, 300);
			}
			
			for (var id in elems) {
				if ($.isArray(elems[id].value)) {
					elemValue = elems[id].value[legendIndex];
				} else {
					elemValue = elems[id].value;
				}
				
				if ((typeof sliceOptions.sliceValue != "undefined" && elemValue == sliceOptions.sliceValue)
					|| ((typeof sliceOptions.sliceValue == "undefined")
						&& (typeof sliceOptions.min == "undefined" || elemValue >= sliceOptions.min)
						&& (typeof sliceOptions.max == "undefined" || elemValue < sliceOptions.max))
				) {
					(function(id) {
						if (hidden == 0) {
							elems[id].mapElem.animate({"opacity":legendOptions.hideElemsOnClick.opacity}, 300, "linear", function() {(legendOptions.hideElemsOnClick.opacity == 0) && elems[id].mapElem.hide();});
							elems[id].textElem && elems[id].textElem.animate({"opacity":legendOptions.hideElemsOnClick.opacity}, 300, "linear", function() {(legendOptions.hideElemsOnClick.opacity == 0) && elems[id].textElem.hide();});
						} else {
							if (legendOptions.hideElemsOnClick.opacity == 0) {
								elems[id].mapElem.show();
								elems[id].textElem && elems[id].textElem.show();
							}
							elems[id].mapElem.animate({"opacity":typeof elems[id].mapElem.originalAttrs.opacity != "undefined" ? elems[id].mapElem.originalAttrs.opacity : 1}, 300);
							elems[id].textElem && elems[id].textElem.animate({"opacity":typeof elems[id].textElem.originalAttrs.opacity != "undefined" ? elems[id].textElem.originalAttrs.opacity : 1}, 300);
						}
					})(id);
				}
			}

			$(elem.node).attr(hiddenNewAttr);
			$(label.node).attr(hiddenNewAttr);

			if ((typeof hideOtherElems === "undefined" || hideOtherElems === true) 
				&& typeof legendOptions.exclusive !== "undefined" && legendOptions.exclusive === true
			) {
				$("[data-type='elem'][data-hidden=0]", $container).each(function() {
					if ($(this).attr('data-index') !== $(elem.node).attr('data-index')) {
						$(this).trigger('click', false);
					}
				});
			}
		};
		$(label.node).on("click", hideMapElems);
		$(elem.node).on("click", hideMapElems);

		if (typeof sliceOptions.clicked !== "undefined" && sliceOptions.clicked === true) {
			$(elem.node).trigger('click', false);
		}
	};
	
	/**
	* Create all legends for a specified type (area or plot)
	* @param $container the map container
	* @param options map options
	* @param legendType the type of the legend : "area" or "plot"
	* @param elems collection of plots or areas displayed on the map
	* @param scale scale ratio of the map
	*/
	$.fn.mapael.createLegends = function ($container, options, legendType, elems, scale) {
		var legends = [];
		
		if ($.isArray(options.legend[legendType])) {
			for (var j = 0; j < options.legend[legendType].length; ++j) {
				legends.push($.fn.mapael.drawLegend(options.legend[legendType][j], $container, options, legendType, elems, scale, j));
			}
		} else {
			legends.push($.fn.mapael.drawLegend(options.legend[legendType], $container, options, legendType, elems, scale));
		}
		return legends;
	};
	
	/**
	* Set the attributes on hover and the attributes to restore for a map element
	* @param elem the map element
	* @param originalAttrs the original attributes to restore on mouseout event
	* @param attrsHover the attributes to set on mouseover event
	*/
	$.fn.mapael.setHoverOptions = function (elem, originalAttrs, attrsHover) {
		// Disable transform option on hover for VML (IE<9) because of several bugs
		if (Raphael.type != "SVG") delete attrsHover.transform;
		elem.attrsHover = attrsHover;
		
		if (elem.attrsHover.transform) elem.originalAttrs = $.extend({transform : "s1"}, originalAttrs);
		else elem.originalAttrs = originalAttrs;
	};
	
	/**
	* Set the hover behavior (mouseover & mouseout) for plots and areas
	* @param paper Raphael paper object
	* @param mapElem the map element
	* @param textElem the optional text element (within the map element)
	*/
	$.fn.mapael.setHover = function (paper, mapElem, textElem) {
		var $mapElem = {}
			, $textElem = {}
			, hoverTO = 0
			, overBehaviour = function() {hoverTO = setTimeout(function () {$.fn.mapael.elemHover(paper, mapElem, textElem);}, 120);}
			, outBehaviour = function () {clearTimeout(hoverTO);$.fn.mapael.elemOut(paper, mapElem, textElem);};
			
		$mapElem = $(mapElem.node);
		$mapElem.on("mouseover", overBehaviour);
		$mapElem.on("mouseout", outBehaviour);
		
		if (textElem) {
			$textElem = $(textElem.node);
			$textElem.on("mouseover", overBehaviour);
			$(textElem.node).on("mouseout", outBehaviour);
		}
	};
	
	/**
	* Set he behaviour for "mouseover" event
	* @param paper paper Raphael paper object
	* @param mapElem mapElem the map element
	* @param textElem the optional text element (within the map element)
	*/
	$.fn.mapael.elemHover = function (paper, mapElem, textElem) {
		mapElem.animate(mapElem.attrsHover, mapElem.attrsHover.animDuration);
		textElem && textElem.animate(textElem.attrsHover, textElem.attrsHover.animDuration);
		paper.safari();
	};
	
	/**
	* Set he behaviour for "mouseout" event
	* @param paper Raphael paper object
	* @param mapElem the map element
	* @param textElem the optional text element (within the map element)
	*/
	$.fn.mapael.elemOut = function (paper, mapElem, textElem) {
		mapElem.animate(mapElem.originalAttrs, mapElem.attrsHover.animDuration);
		textElem && textElem.animate(textElem.originalAttrs, textElem.attrsHover.animDuration);
		paper.safari();
	};
	
	/**
	* Get element options by merging default options, element options and legend options
	* @param defaultOptions
	* @param elemOptions
	* @param legendOptions
	*/
	$.fn.mapael.getElemOptions = function(defaultOptions, elemOptions, legendOptions) {
		var options = $.extend(true, {}, defaultOptions, elemOptions);
		if (typeof options.value != "undefined") {
			if ($.isArray(legendOptions)) {
				for (var i = 0, length = legendOptions.length;i<length;++i) {
					options = $.extend(true, {}, options, $.fn.mapael.getLegendSlice(options.value[i], legendOptions[i]));
				}
			} else {
				options = $.extend(true, {}, options, $.fn.mapael.getLegendSlice(options.value, legendOptions));
			}
		}
		return options;
	};
	
	/**
	* Get the coordinates of the text relative to a bbox and a position
	* @param bbox the boundary box of the element
	* @param textPosition the wanted text position (inner, right, left, top or bottom)
	*/
	$.fn.mapael.getTextPosition = function(bbox, textPosition, margin) {
		var textX = 0
			, textY = 0
			, textAnchor = "";
			
		switch (textPosition) {
			case "bottom" :
				textX = (bbox.x + bbox.x2) / 2;
				textY = bbox.y2 + margin;
				textAnchor = "middle";
				break;
			case "top" :
				textX = (bbox.x + bbox.x2) / 2;
				textY = bbox.y - margin;
				textAnchor = "middle";
				break;
			case "left" :
				textX = bbox.x - margin;
				textY = (bbox.y + bbox.y2) / 2;
				textAnchor = "end";
				break;
			case "right" :
				textX = bbox.x2 + margin;
				textY = (bbox.y + bbox.y2) / 2;
				textAnchor = "start";
				break;
			default : // "inner" position
				textX = (bbox.x + bbox.x2) / 2;
				textY = (bbox.y + bbox.y2) / 2;
				textAnchor = "middle";
		}
		return {"x" : textX, "y" : textY, "textAnchor" : textAnchor};
	};
	
	/**
	* Get the legend conf matching with the value
	* @param value the value to match with a slice in the legend
	* @param legend the legend params object
	* @return the legend slice matching with the value
	*/
	$.fn.mapael.getLegendSlice = function (value, legend) {
		for(var i = 0, length = legend.slices.length; i < length; ++i) {
			if ((typeof legend.slices[i].sliceValue != "undefined" && value == legend.slices[i].sliceValue)
				|| ((typeof legend.slices[i].sliceValue == "undefined")
					&& (typeof legend.slices[i].min == "undefined" || value >= legend.slices[i].min)
					&& (typeof legend.slices[i].max == "undefined" || value < legend.slices[i].max))
			) {
				return legend.slices[i];
			}
		}
		return {};
	};

	$.fn.mapael.animationIntervalID = null;

	/**
	 * Animated view box changes
	 * As from http://code.voidblossom.com/animating-viewbox-easing-formulas/,
	 * (from https://github.com/theshaun works on mapael)
	 * @param paper paper Raphael paper object
	 * @param x coordinate of the point to focus on
	 * @param y coordinate of the point to focus on
	 * @param w map defined width
	 * @param h map defined height
	 * @param duration defined length of time for animation
	 * @param easying_function defined Raphael supported easing_formula to use
	 * @param callback method when animated action is complete
	 */
	$.fn.mapael.animateViewBox = function animateViewBox($container, paper, x, y, w, h, duration, easingFunction ) {
		var cx = paper._viewBox ? paper._viewBox[0] : 0
			, dx = x - cx
			, cy = paper._viewBox ? paper._viewBox[1] : 0
			, dy = y - cy
			, cw = paper._viewBox ? paper._viewBox[2] : paper.width
			, dw = w - cw
			, ch = paper._viewBox ? paper._viewBox[3] : paper.height
			, dh = h - ch
			, easingFunction = easingFunction || "linear"
			, interval = 25
			, steps = duration / interval
			, current_step = 0
			, easingFormula = Raphael.easing_formulas[easingFunction];

		clearInterval($.fn.mapael.animationIntervalID);
	 
		$.fn.mapael.animationIntervalID = setInterval(function() {
				var ratio = current_step / steps;
				paper.setViewBox(cx + dx * easingFormula(ratio),
								cy + dy * easingFormula(ratio),
								cw + dw * easingFormula(ratio),
								ch + dh * easingFormula(ratio), false);
				if (current_step++ >= steps) {
					clearInterval($.fn.mapael.animationIntervalID);
					clearTimeout($.fn.mapael.zoomTO);
					$.fn.mapael.zoomTO = setTimeout(function(){$container.trigger("afterZoom", {x1 : x, y1 : y, x2 : (x+w), y2 : (y+h)});}, 150);
				}
			}
			, interval
		);
	};
	
	// Default map options
	$.fn.mapael.defaultOptions = {
		map : {
			cssClass : "map"
			, tooltip : {
				cssClass : "mapTooltip",
				target: null
			}
			, defaultArea : {
				attrs : {
					fill : "#343434"
					, stroke : "#5d5d5d"
					, "stroke-width" : 1
					, "stroke-linejoin" : "round"
				}
				, attrsHover : {
					fill : "#f38a03"
					, animDuration : 300
				}
				, text : {
					position : "inner"
					, margin : 10
					, attrs : {
						"font-size" : 15
						, fill : "#c7c7c7"
					}
					, attrsHover : {
						fill : "#eaeaea"
						, "animDuration" : 300
					}
				}
				, target : "_self"
			}
			, defaultPlot : {
				type : "circle"
				, size : 15
				, attrs : {
					fill : "#0088db"
					, stroke : "#fff"
					, "stroke-width" : 0
					, "stroke-linejoin" : "round"
				}
				, attrsHover : {
					"stroke-width" : 3
					, animDuration : 300
				}
				, text : {
					position : "right"
					, margin : 10
					, attrs : {
						"font-size" : 15
						, fill : "#c7c7c7"
					}
					, attrsHover : {
						fill : "#eaeaea"
						, animDuration : 300
					}
				}
				, target : "_self"
			}
			, defaultLink : {
				factor : 0.5
				, attrs : {
					stroke : "#0088db"
					, "stroke-width" : 2
				}
				, attrsHover : {
					animDuration : 300
				}
				, text : {
					position : "inner"
					, margin : 10
					, attrs : {
						"font-size" : 15
						, fill : "#c7c7c7"
					}
					, attrsHover : {
						fill : "#eaeaea"
						, animDuration : 300
					}
				}
				, target : "_self"
			}
			, zoom : {
				enabled : false
				, maxLevel : 10
				, step : 0.25
				, zoomInCssClass : "zoomIn"
				, zoomOutCssClass : "zoomOut"
				, mousewheel : true
				, touch : true
				, animDuration : 200
				, animEasing : "linear"
			}
		}
		, legend : {
			area : []
			, plot : []
		}
		, areas : {}
		, plots : {}
		, links : {}
	};
	
	$.fn.mapael.legendDefaultOptions = {
		area : {
			cssClass : "areaLegend"
			, display : true
			, marginLeft : 10
			, marginLeftTitle : 5
			, marginBottomTitle: 10
			, marginLeftLabel : 10
			, marginBottom : 10
			, titleAttrs : {
				"font-size" : 16
				, fill : "#343434"
				, "text-anchor" : "start"
			}
			, labelAttrs : {
				"font-size" : 12
				, fill : "#343434"
				, "text-anchor" : "start"
			}
			, labelAttrsHover : {
				fill : "#787878"
				, animDuration : 300
			}
			, hideElemsOnClick : {
				enabled : true
				, opacity : 0.2
			}
			, slices : []
			, mode : "vertical"
		}
		, plot : {
			cssClass : "plotLegend"
			, display : true
			, marginLeft : 10
			, marginLeftTitle : 5
			, marginBottomTitle: 10
			, marginLeftLabel : 10
			, marginBottom : 10
			, titleAttrs : {
				"font-size" : 16
				, fill : "#343434"
				, "text-anchor" : "start"
			}
			, labelAttrs : {
				"font-size" : 12
				, fill : "#343434"
				, "text-anchor" : "start"
			}
			, labelAttrsHover : {
				fill : "#787878"
				, animDuration : 300
			}
			, hideElemsOnClick : {
				enabled : true
				, opacity : 0.2
			}
			, slices : []
			, mode : "vertical"
		}
	};
})(jQuery);

/**
 * IDF MAP
 */
(function($) {
    $.extend(true, $.fn.mapael,
        {
            maps :{
                idf : {
                    width : 606,
                    height : 500,
                    getCoords : function (lat, lon) {
                        return {'x' : lat, 'y' : lon};
                    },
                    elems : {
                        "path6" : "m 285.25,201.65 1.15,0.46 5.23,-1.22 4.97,2.26 -0.42,4.98 -1.18,3.08 -6.3,-0.09 -1.74,-1.91 -2.54,-0.3 -4.27,-2.04 -3.41,1.35 -6.68,3.57 -2,0.15 -0.89,-0.89 -2.31,0.94 -3.08,-0.51 -4.54,-2.09 -3.28,-1.13 -3.05,-1.28 -2.18,-1.18 -2.3,0.93 -1.09,-2.08 -1.24,0.1 -2.36,-1.16 -1.38,-3.69 -6.09,-2.86 0.4,-2.29 1.59,-3.74 3.61,-2.84 2.45,0.84 1.23,-2.26 5.11,0.67 1.18,-2.73 4.98,-3.27 4.15,-2.42 2.59,-0.25 5.61,-0.09 3.58,-0 1.14,-0.01 4.91,0.23 1.79,1.94 0.53,2.64 0.42,2.21 2.64,2.07 0.65,2.09 0.47,6.98 0.24,2.31 0,0 0,0 -0.1,1.01 -0.62,3.65 0.73,0.99 z",
                        "path8" : "m 394.43,474.29 -7.73,4.97 -4.81,-0.71 -0.76,-2.31 0.26,-6.3 2.61,-2.79 0.13,-1.26 -3.1,-1.55 -2.27,1.05 -2.41,-0.81 -2.01,1.55 -2.55,-0.32 -2.29,1.06 -4.74,-1.93 4.62,5.61 0.24,2.43 -8.52,3.17 -4.16,4.88 -8.08,-0.17 -2.07,1.74 -0.73,0.05 -6.49,-7.18 -9.21,2.73 -6.88,-0.02 -1.88,-3.52 -8.6,0.07 -4.13,4.68 0.12,1.25 -11.6,-1.58 -4.85,1.33 -0.81,0.86 -3.42,-0.84 0.42,-2.32 4.4,-2.59 2.89,-4 -0.05,-2.35 2.99,-3.84 5.98,3.18 2.25,-3.25 -1.54,-6.26 1.73,-4.68 1.27,-0.35 0.72,-1.88 -1.42,-6.08 -0.85,-0.01 0.35,-4.87 -2.07,-0.81 -0.28,-3.71 -5.71,-0.21 -1.69,-2.02 -0.2,-2.6 -1.99,-1.74 -4.5,1.86 -1.88,-1.59 -1.14,0.49 -2.44,-1.01 -2.31,-3.17 -0.41,-1.1 0.26,-12.65 -4.63,-8.38 -1.87,-1.97 -0.76,-3.94 2.31,1.13 4.86,-1.57 3.58,1.04 -0.87,-5.05 2.83,-3.75 -2.92,-1.89 2.91,-2.43 2.49,0.47 -0.19,-2.55 8.47,-3.34 -2.21,-3.1 3.18,-2.48 5.29,0.78 3.98,-3.53 6.54,1.06 -7.64,-10.25 -3.17,-0.87 -0.12,-7.08 -0.08,-2.05 -1.57,-1.54 0.44,-0.69 1.63,-0.81 -0.84,-8.98 2.05,-1.62 0.46,-2.7 0.48,-5.49 -1.22,-0.05 -0.56,-2.4 -2.39,-0.58 3.12,-9.85 -2.62,-0.13 4.85,-7.4 0.47,-2.51 3.08,-1.99 -2.53,0.15 -0.88,-3.9 6.01,-5.26 0.3,-4.63 -4.19,-2.45 -2.21,-5.76 1.01,-0.8 4.97,-0.72 0.48,-3.97 1.43,-2.18 -3.64,-2.99 3.56,-5.66 2.45,-0.36 2.12,1.38 2.45,-2.67 2.42,-0.34 -0.93,-4.8 -2.24,-1 1.56,-2.71 -0.85,-0.78 -1.41,-2.43 -0.17,-0.68 3.19,-5.43 3.69,-3.41 -1.75,-4.78 3.04,-2.58 -0.5,-3.82 4.44,-0.19 -2.13,-4.75 -3.96,0.36 -1,-0.89 3.04,-7.27 -1.86,-1.57 1.29,-3.38 -1.08,-0.54 0.92,-2.65 -2.4,-7.78 -3.15,-7.46 2.23,-1.08 1.25,-3.42 -4.97,-0.39 0.68,-4.94 -2.83,-2.62 1.82,-1.9 5.01,-1.88 -0.13,-2.58 1.54,-2.08 0.24,-0.21 -0.85,-0.89 0.88,-5.85 2.64,-1.67 -0.04,-2.32 -1.65,-1.29 -1.01,-4.18 -6.49,-10.11 -0.12,-1.34 2.56,-0.73 1.07,-2.45 -1.03,-5.2 -1.1,-0.49 -1.44,-4.24 -3.26,0.99 -0.61,-1.09 -3.16,-0.74 -0.82,-3.63 2.49,0.48 4.67,-1.91 1.65,-4.66 2.64,-2.67 3.8,-0.23 -5.61,-4.75 4.66,-7.9 4.1,-3.44 0.99,-2.48 2.3,0.2 3.58,-5.39 1.87,3.38 2.63,-0.2 6.96,5.68 3.53,3.58 -0.27,2.31 -0.29,1.19 3.33,1.11 5.46,-6.09 2.7,7.79 6.6,-0.97 6.26,-4.82 -4.32,-3.05 5.08,0.16 -1.07,-2.24 1.98,-0.58 4.48,-2.86 4.18,4.82 2.44,0.84 2.49,-0.73 2.84,5.78 4.05,-0.49 4.64,-2.8 1.24,0.57 1.68,-3.23 5.78,2.76 2.48,-0.65 1.03,0.78 1.2,-0.33 0.84,-3.59 2.3,0.83 3.19,-1.83 1.05,0.65 0.81,5.5 3.45,0.96 1.06,-4.6 2.99,-1.76 2.27,-0.8 4.53,1.55 0.99,-0.7 8.09,1.32 -2.39,-4.1 -0.11,-2.39 3.97,-6.08 1.9,1.87 8.99,2.16 1.74,-0.68 0.61,0.75 3.81,0.19 2.99,2.33 3.82,0.3 -2.4,5.51 0.74,1.98 2.35,1.36 3.55,5.72 -0.21,2.34 2.51,2.4 -0.01,1.27 -2.44,0.94 -1.1,5.05 -3.37,1.99 -0.12,2.45 2.2,2.89 7.02,2.59 2.22,2.45 0.44,2.21 3.58,1.29 0.4,1.21 1.11,-0.43 0.54,4.53 4.69,0.97 1.47,4.73 1.99,5.09 -0.69,1.61 1.28,2.22 1.11,0.62 3.66,-1.07 5.36,-3.37 1.93,5.19 0.24,5.52 4.41,5.14 8.05,-4.55 1.45,-3.6 2.02,7.78 -1.22,5.25 2.74,3 0.38,5.41 1.16,0.73 4.87,-1.63 -1.77,3.69 2.47,1.04 3.72,-1.52 1.41,2.28 6.09,2.06 -0.73,3.09 3.27,1.82 2.09,-2.71 3.84,-0.55 1.6,6.51 -1.53,3.76 0.53,4.01 -1.6,1.18 -1.58,-2.78 -1.19,-0.51 -6.59,3.5 -3.76,-0.45 -3.41,-1.85 -2.67,2.97 0.36,1.28 3.5,1.74 5.06,0.34 0.48,5.19 -0.11,1.28 -3.49,1.55 -2.22,-1.23 -2.55,0.16 -3.26,8.7 0.52,2.48 2.54,0.82 4.95,-1.69 2.15,1.54 0.08,3.88 1.54,2.09 6.34,-0.36 -0.14,3.83 0.12,2.3 0,6.75 2.79,2.92 -1.34,0.2 -0.41,3.95 -3.66,1.74 -3.56,4.04 0.91,2.18 -0.93,0.99 4.21,5.06 -1.95,6.47 6.61,-1.16 3.94,-3.69 6.64,1.17 3.94,-1.06 -3.7,3.84 0.65,1.18 5.14,1.34 3.75,3.8 0.03,1.29 -12.13,4.53 -0.76,1.06 2.53,4.57 -5.94,0.88 -1.75,3.26 -4.18,2.91 -0.9,1 4.4,8.01 -0.14,3.25 -2.34,0.56 -5.65,4.45 -3.67,0.07 -5.76,-1.88 -2.27,2.13 5.05,6.06 2.64,6.02 -0.06,2.57 -3.65,-0.17 -4.32,1.87 -5.06,3.12 3.43,3.83 -0.12,2.6 2.32,3.16 -0.37,5.32 -1.91,1.85 -0.97,3.76 4.9,1.49 -1.78,2.29 4.08,-0.02 0.06,2.5 -1.54,7.29 -3.77,-0.32 -3.91,-2.99 -2.53,0.08 -2.34,2.81 -0.59,6.28 -1.96,1.36 0.04,-2.56 -1.26,-0.06 -1.38,2.1 -2.53,0.03 -1.66,0.42 -3.48,-1.45 -1.26,-0.05 -0.3,1.21 -7.14,-3.27 -0.4,1.26 -2.44,-0.06 -5.46,5.16 -6.36,-1.98 -3.1,1.04 -2.6,1.33 -2.77,-2.01 -2.28,0.5 -1.03,-2.5 -2.38,-1.21 -1.14,2.2 -5.84,1.84 -1.29,-2.06 -4.5,1.55 -2.01,1.64 -2.91,5.79 -0.99,-0.81 -0.22,-2.39 -2.57,0.13 -2.14,-1.33 -3.6,1.21 -4.47,-0.9 -3.09,7.32 0.8,4.77 -6.45,8.4 3.06,2.6 -1.92,1.66 2.51,4.26 -1.29,3.8 4.92,1.48 1.01,8.6 -3.86,0.38 -5.16,10.35 -1.77,4.93 -2.3,1.2 -2.12,-1.04 -4.49,2.18 -0.19,3.58 -4.04,0.65 -5.37,5.32 0.4,6 0,0 0,0 -9.43,1.53 -7.56,1.14 -1.08,0.17 z",
                        "path10" : "m 145.74,356.61 -1.21,-0.26 -2.62,0.05 -2.12,-1.55 -3.58,-0.89 -2.06,-4.43 -1.15,-3.59 -6.22,0.39 -2.16,-0.78 -0.36,-2.41 -1.78,-1.76 0.69,-2.1 -2.48,-2.85 0.76,-2.51 -3.23,-5.83 -0.1,-5.42 2.9,-10.45 -2.34,0.42 -3.39,-3.76 -0.87,-3.68 -3.41,-1.58 -2.43,1.02 -7.6,-2.02 0.27,-1.26 -2.12,-1.47 4.24,-8.59 -0.75,-2.33 -6.1,-0.54 -0.62,1.11 -1.5,-1.4 1.96,-0.81 -2.23,-0.65 -4.08,1.97 -2.27,-3.07 -0.11,-2.54 -1.88,-1.64 0.54,-2.27 -2.74,-2.65 0.63,-2.48 -5.27,0.33 -3.87,-3.65 -1.24,-1.36 0.96,-6.22 1.35,-3.62 -7.46,-3.03 0.11,-3.2 3.21,-1.92 -1.78,-0.57 0.54,-0.83 6.52,-8.66 1.34,-0.26 0.65,-1.61 0.61,-3.45 -5.03,-4.54 -5.21,-1.11 -0.49,-1.66 1.22,-2.34 -2.67,-4.55 0.72,-9.19 2.79,-2.09 0.08,-1.16 -2.18,-4.88 3.28,-2.25 0.12,-1.34 -2.11,-1.6 -2.4,-0.47 1.51,-5.09 -2.77,-2.53 -3.2,-1.33 -0.2,1.17 -3.2,-3.22 4.56,-7.03 -6.4,-6.31 1.51,-1.58 -0.67,-1.94 -0.28,-1.06 -0.57,-1.25 -3.91,-1.29 -2.33,1.17 -1.47,-2.13 0.91,-2.4 -2.46,-2.99 -0.07,0 2.48,-4.84 -2.54,0.22 -1.45,-5 5.98,-4.84 -1.25,-0.07 -1.41,-2.07 -3.61,1.68 -4,-0 -1.91,1.7 -2.29,-5.49 2.39,-0.85 2.47,-5.59 -1.61,-1.62 0.8,-1.98 -1.33,-1.5 -3.57,-3.03 -0.35,-3.89 -2.02,-3.38 0.83,-2.5 -1.01,-0.85 3.67,-3.77 3.79,3.78 2.57,0.8 4.32,-2.81 2.51,-7.27 -0.62,-2.51 1.59,1.7 1.17,4.52 6.45,-1.5 3.63,0.83 2.97,-2.48 5.67,-2.25 2.49,-0.37 1.18,2.3 1.38,2.63 1.51,-1.05 6.78,-2.81 6.18,0.99 4.26,2.78 2.44,2.52 -0.94,3.39 7.58,4.62 2.22,-2.1 0.91,0.68 3.97,0.21 0.07,-2.66 2.08,-3.18 2.87,2.16 4.77,0.01 1.26,-0.12 1.33,-3.12 -0.71,-2.33 4.83,-1.59 2.1,-0.09 4.33,2.88 0.19,1.77 6.12,2.89 -3.68,9.35 2.03,1.4 0.78,3.74 -0.83,2.42 0.63,-0.05 1.76,-1.52 3.42,-0.55 0.43,-5.08 6.44,-5.95 1.42,0.86 -0.42,1.64 6.43,7.75 2,-1.35 2.39,0.3 0.54,1.07 2.58,-0.53 3.67,1.55 2.66,-0.66 3.31,4.27 0.7,0.72 4.07,4.04 0.73,-1.09 5.13,-0.42 4.6,-2.45 1.85,2.54 3.4,-5.03 5.87,2.2 3.43,-3.65 1.41,3.83 -1.36,5.35 1.5,2.28 6.44,1.17 3.5,1.81 2.21,3.21 0.79,3.79 -0.02,1.46 -1.28,2.51 8.38,1.4 0.05,3.53 -1.84,2.1 1.45,4.48 -1.39,1.85 0.35,4 -6.75,3.72 -1.27,1.26 -2.85,5.9 -2.04,3.78 0.86,2.52 -0.87,2.29 2.41,4.2 -2.53,0.4 -1.08,3.79 0.66,3.27 0.76,2.76 -0.19,0.99 2.7,2.37 3.97,-0.47 2.35,5.52 -0.77,1.01 5.06,-0.45 1.67,1.89 0.22,2.53 3.64,1.01 0.62,1.12 -0.02,2.13 0.16,1.3 -1.11,0.7 -3.91,0.24 -1.78,-1.69 -2.59,-0.17 -0.78,0.98 1.24,3.46 -0.77,3.68 -3.66,-1.31 -3.47,1.95 -2.68,-0.07 -3.19,2.34 -0.02,1.35 -1.01,2.32 -4.43,-1.66 -3.37,1.31 -1.09,0.76 2.57,4.57 -0.73,2.55 0.68,1.3 -3.4,5.38 0.16,2.52 -2.19,-1.57 -1.89,4.89 -3.16,-1.36 -0.84,0.79 -2.79,0.03 -2.53,-0.01 -0.86,2.36 -1.26,0.18 -1.03,0.6 -1.25,5.8 -0.48,2.37 -3.55,-0.77 -0.43,2.33 2.2,4.48 3.73,0.27 0.27,3.72 1.48,1.94 0.26,0.21 3.84,3.56 -0.72,3.61 -5.11,1.19 -0.52,2.58 0.68,3.63 -3.58,4.15 -1.16,7.98 -8.92,0.26 -0.86,0.97 -4.37,-2.41 -6.37,-0.54 -1.02,5.1 7.18,5.35 3.62,0.19 0.29,2.6 -2.48,0.63 -0.97,-0.63 -2.85,1.68 -4.87,10.74 -0.33,5.58 -2.55,0.88 -1.68,2.11 -0.1,4.04 1.44,2.23 0,0 0,0 -0.61,3.75 -2.51,0.78 -1.48,2.18 z",
                        "relief4" : "m 267.28,409.03 -0.98,-0.64 -6.29,-6.27 -0.5,-2.49 -3.15,0.47 -1.24,0.55 -3.23,7.31 -2.21,0.78 -5.84,-2.34 -3.75,5.26 -2.52,1.15 0.86,-6.61 -2.63,-0.39 2.19,-5.26 -3.76,0.04 -4.41,-2.73 -1.94,-3.23 -6.38,8.12 -0.38,3.92 -2.76,-0.52 -0.48,0.91 -3.7,-0.75 -0.25,2.38 2.06,2.27 -0.1,1.63 -13.23,0.43 0.85,-3.99 -2.58,0.13 -4.27,4.74 -9.03,-0.48 -0.35,2.04 -2.15,1.55 -3.68,-1 -5.13,1.22 -3.93,-0.54 -3.87,-0.69 -4.4,-5.74 -0.67,-2.28 4.52,-2.12 -0.2,-3.56 1.77,-1.87 -2.98,-4.58 1.38,-6.55 3.07,-2.65 -2.6,-6.01 -2.66,-0.51 2.82,-7.25 -3.86,-2.06 -3.51,-0.83 -4.72,0.86 -0.13,-2.98 -0.99,-0.45 3.44,-3.61 -0.37,-5.17 1.48,-2.14 -2.26,-0.68 -0.85,-4.3 -2.17,-1.54 -1.42,-2.24 0.13,-4.04 1.69,-2.09 2.56,-0.86 0.38,-5.57 4.95,-10.71 2.86,-1.66 0.97,0.64 2.48,-0.61 -0.27,-2.6 -3.62,-0.21 -7.14,-5.4 1.06,-5.09 6.37,0.59 4.35,2.45 0.87,-0.96 8.93,-0.19 1.22,-7.98 3.62,-4.12 -0.65,-3.63 0.54,-2.58 5.12,-1.15 0.75,-3.6 -3.81,-3.59 -0.26,-0.21 -1.46,-1.95 -0.24,-3.73 -3.73,-0.3 -2.16,-4.49 0.44,-2.33 3.55,0.8 0.5,-2.37 1.29,-5.79 1.04,-0.59 1.27,-0.17 0.87,-2.36 2.53,0.03 2.79,-0.01 0.85,-0.78 3.15,1.39 1.92,-4.87 2.18,1.58 -0.14,-2.52 3.44,-5.35 -0.66,-1.3 0.75,-2.55 -2.53,-4.59 1.09,-0.76 3.38,-1.28 4.41,1.69 1.03,-2.32 0.03,-1.35 3.21,-2.32 2.68,0.09 3.49,-1.92 3.65,1.34 0.8,-3.68 -1.21,-3.47 0.79,-0.97 2.59,0.19 1.77,1.7 3.91,-0.21 1.11,-0.7 -0.15,-1.31 0.58,0.64 1,3.31 4.4,1.9 4.94,0.27 1.75,1.56 1.91,3.35 -2.39,2.84 0.98,2.41 1.29,0.17 4.82,-2.01 0.41,3.86 2.48,-0.38 1.92,-7.07 0.81,-0.72 1.77,1 2.47,2.78 3.47,0.94 4.11,-2.84 0.1,7.07 0.05,2.99 4.08,0.06 6.3,-2.27 0.81,3.21 5.38,-2.4 1.29,-0.51 0.69,1.85 2.12,2.27 -0.32,-2.52 3.34,-2.15 2.63,-0.22 0.62,-0.01 2.36,-0.56 6.57,-2.13 2.85,8.71 2.1,2.39 -0.7,0.56 1.07,1.93 3.4,0.54 1.19,3.67 5.84,-1.13 2.24,1 0.93,4.8 -2.42,0.34 -2.45,2.67 -2.12,-1.38 -2.45,0.36 -3.56,5.66 3.64,2.99 -1.43,2.18 -0.48,3.97 -4.97,0.72 -1.01,0.8 2.21,5.76 4.19,2.45 -0.3,4.63 -6.01,5.26 0.88,3.9 2.53,-0.15 -3.08,1.99 -0.47,2.51 -4.85,7.4 2.62,0.13 -3.12,9.85 2.39,0.58 0.56,2.4 1.22,0.05 -0.48,5.49 -0.46,2.7 -2.05,1.62 0.84,8.98 -1.63,0.81 -0.44,0.69 1.57,1.54 0.08,2.05 0.12,7.08 3.17,0.87 7.64,10.25 -6.54,-1.06 -3.98,3.53 -5.29,-0.78 -3.18,2.48 2.21,3.1 -8.47,3.34 0.19,2.55 -2.49,-0.47 -2.91,2.43 2.92,1.89 -2.83,3.75 0.87,5.05 -3.58,-1.04 -4.86,1.57 -2.31,-1.13 0.76,3.94 1.87,1.97 0,0 0,0 -0.98,2.12 -7.53,2.5 -0.57,-1.01 z",
                        "path14" : "m 249.04,243.57 -1.29,-0.17 -0.98,-2.41 2.39,-2.84 -1.91,-3.35 -1.75,-1.56 -4.94,-0.27 -4.4,-1.9 -1,-3.31 -0.58,-0.64 0.04,-2.13 -0.61,-1.12 -3.63,-1.04 -0.2,-2.53 -1.65,-1.91 -5.06,0.41 0.78,-1 -2.3,-5.54 -3.98,0.44 -2.68,-2.39 0.2,-0.99 -0.74,-2.76 -0.63,-3.28 1.11,-3.78 2.53,-0.39 -2.38,-4.22 0.88,-2.29 -0.84,-2.52 2.07,-3.77 2.89,-5.88 1.28,-1.25 6.78,-3.67 5.12,-4.59 2.78,-2.74 4.25,-3.46 5.15,-3.59 6.01,-1.84 5.29,1.22 5.93,2.54 0.24,3.88 -1.96,3.41 -1.66,1.58 -0.57,1.06 -1.56,0.73 1.52,5.29 -4.15,2.42 -4.98,3.27 -1.18,2.73 -5.11,-0.67 -1.23,2.26 -2.45,-0.84 -3.61,2.84 -1.59,3.74 -0.4,2.29 6.09,2.86 1.38,3.69 2.36,1.16 1.24,-0.1 1.09,2.08 2.3,-0.93 2.18,1.18 3.05,1.28 3.28,1.13 4.54,2.09 -0.74,1.25 -2.58,1.46 1.22,3.28 -1.4,5.26 1.81,2.38 -1.55,4.34 -1.05,1.53 -1.6,4.72 2.78,2.29 0,0 0,0 -1.92,7.07 -2.48,0.38 -0.41,-3.86 z",
                        "path16" : "m 314.39,203.48 0.14,-1.34 -5.5,-3.7 -0.51,0.47 -2.48,-2.76 -1.09,0.6 -0.84,-1.65 -3.81,-0.61 -7,2.28 -1.86,1.65 -2.52,-0.65 -2.08,1.51 -2.62,-0.2 -0.68,0.03 -0.24,-2.31 -0.47,-6.98 -0.65,-2.09 -2.64,-2.07 -0.42,-2.21 -0.53,-2.64 -1.79,-1.94 -4.91,-0.23 -1.14,0.01 -3.58,0 -5.61,0.09 -2.59,0.25 -1.52,-5.29 1.56,-0.73 0.57,-1.06 1.66,-1.58 1.96,-3.41 -0.24,-3.88 -5.93,-2.54 -5.29,-1.22 0.34,-0.16 -0.95,-2.96 2.63,-2.84 3.71,1.64 1.77,1.5 2.11,-0.47 1.26,1.68 2.7,-4.58 2.49,0.64 3.28,-3.32 2.5,0.88 1.66,0.3 6.34,5.94 2.94,-0.61 7.34,0.81 2.18,0.02 0.89,0.29 1.84,-3.25 6.31,-3.76 1.25,0.21 1.16,-0.99 0.36,-1.26 2.48,-0.94 5.49,-9.08 3.81,0.05 1.39,-2.12 3.26,-0.99 1.44,4.24 1.1,0.49 1.03,5.2 -1.07,2.45 -2.56,0.73 0.12,1.34 6.49,10.11 1.01,4.18 1.65,1.29 0.04,2.32 -2.64,1.67 -0.88,5.85 0.85,0.89 -0.24,0.21 -1.54,2.08 0.13,2.58 -5.01,1.88 -1.82,1.9 2.83,2.62 -0.68,4.94 4.97,0.39 -1.25,3.42 -2.23,1.08 3.15,7.46 2.4,7.78 -0.92,2.65 0,0 0,0 -5.69,-3.01 -0.4,-1.23 0.06,-2.39 z",
                        "path18" : "m 311.57,255.47 0.7,-0.56 -2.1,-2.39 -2.85,-8.71 -6.57,2.13 -2.36,0.56 -0.62,0.01 -2.63,0.22 -3.34,2.15 0.32,2.52 -2.12,-2.27 -0.69,-1.85 -1.29,0.51 -5.38,2.4 -0.81,-3.21 -6.3,2.27 -4.08,-0.06 -0.05,-2.99 -0.1,-7.07 -4.11,2.84 -3.47,-0.94 -2.47,-2.78 -1.77,-1 -0.81,0.72 -2.78,-2.29 1.6,-4.72 1.05,-1.53 1.55,-4.34 -1.81,-2.38 1.4,-5.26 -1.22,-3.28 2.58,-1.46 0.74,-1.25 3.08,0.51 2.31,-0.94 0.89,0.89 2,-0.15 6.68,-3.57 3.41,-1.35 4.27,2.04 2.54,0.3 1.74,1.91 6.3,0.09 1.18,-3.08 0.42,-4.98 -4.97,-2.26 -5.23,1.22 -1.15,-0.46 -1.69,3.11 -0.73,-0.99 0.62,-3.65 0.1,-1.01 0.68,-0.03 2.62,0.2 2.08,-1.51 2.52,0.65 1.86,-1.65 7,-2.28 3.81,0.61 0.84,1.65 1.09,-0.6 2.48,2.76 0.51,-0.47 5.5,3.7 -0.14,1.34 8.19,5.53 -0.06,2.39 0.4,1.23 5.69,3.01 1.08,0.54 -1.29,3.38 1.86,1.57 -3.04,7.27 1,0.89 3.96,-0.36 2.13,4.75 -4.44,0.19 0.5,3.82 -3.04,2.58 1.75,4.78 -3.69,3.41 -3.19,5.43 0.17,0.68 1.41,2.43 0.85,0.78 -1.56,2.71 0,0 0,0 -5.84,1.13 -1.19,-3.67 -3.4,-0.54 z",
                        "path20" : "m 229.81,162.99 -0.03,-3.53 -8.36,-1.47 1.3,-2.5 0.03,-1.46 -0.76,-3.79 -2.19,-3.22 -3.49,-1.84 -6.43,-1.22 -1.48,-2.29 1.4,-5.34 -1.38,-3.84 -3.45,3.63 -5.86,-2.25 -3.44,5 -1.83,-2.55 -4.62,2.42 -5.14,0.39 -0.74,1.08 -4.04,-4.07 -0.69,-0.73 -3.27,-4.29 -2.66,0.64 -3.65,-1.57 -2.58,0.51 -0.53,-1.07 -2.38,-0.31 -2.01,1.33 -6.37,-7.8 0.43,-1.64 -1.41,-0.87 -6.49,5.9 -0.47,5.08 -3.42,0.53 -1.77,1.51 -0.63,0.05 0.85,-2.41 -0.75,-3.74 -2.02,-1.42 3.75,-9.32 -6.1,-2.93 -0.18,-1.77 -4.31,-2.92 -2.1,0.07 -4.84,1.55 0.7,2.34 -1.35,3.11 -1.26,0.11 -4.77,-0.04 -2.86,-2.19 -2.11,3.16 -0.09,2.66 -3.97,-0.24 -0.9,-0.69 -2.23,2.08 -7.54,-4.68 0.97,-3.38 -2.42,-2.54 -4.24,-2.82 -6.17,-1.04 -6.8,2.76 -1.51,1.04 -1.36,-2.64 3.77,-3.12 -0.98,-0.75 0.24,-3.5 1.81,-3.14 5.51,-7.65 2.05,-2.05 -0.61,-4.51 2.47,-4.06 0.42,-0.56 -0.71,-1.12 2.09,-4.8 -0.72,-2.54 1.43,-1.99 -0.27,-3.51 1.44,-3.7 -0.66,-2.4 0.83,-2.54 6.02,-5.32 1.26,-2.35 1.67,-1.99 7.46,5.54 -1.2,0.56 -0.53,3.86 -4.72,2.16 -0.03,1.32 2.35,0.95 0.22,2.53 3.31,0.76 0.88,4.83 3.4,1.97 5.22,-3.89 0.14,-0.05 4.22,1.99 1.1,-1.88 4.85,3.68 3.64,-0.38 1.34,2.13 -0.69,2.49 3.86,-2.03 6.5,-1.38 0.58,-0.39 1.41,5 13.15,-4.04 0.88,1.02 2.7,-0 3.76,-1.41 2.95,-3.35 6.43,3.1 5.76,-5.02 4.21,-1.29 0.04,-0.11 3.12,-2.44 4.96,-1.72 2.84,-2.73 -0.05,1.26 2.41,0.71 1.37,6 5.1,0.86 3.67,-1.03 2.39,2.99 0.9,-0.93 2.48,0.66 2.62,2.48 -1.47,1.97 1.55,2.51 1.1,0.54 2.85,-2.28 -0.68,-2.29 2.74,1.32 5.06,-0.58 3.36,-1.66 3.3,5.19 -4.4,4.45 6.42,1.15 3.53,-0.78 1.75,-1.78 1.09,0.74 5.08,-1.31 0.63,-3.8 2.77,-2.87 0.45,-2.62 2.4,-0.36 2.85,0.2 9.45,14.5 3.57,-4.63 5.47,3.76 4,-0.87 7.77,2.5 -0.52,1.67 -0.92,2.93 5.37,-2.36 1.19,0.17 0.05,1.2 4.14,2.18 -0.16,1.2 5.66,2.25 0.43,2.32 -2.84,3.85 10.49,2.7 0.77,-7.58 2.25,-1.14 -0.14,1.25 2.44,-0.69 0.73,0.87 1.22,8.09 4.37,2.03 1.61,4.6 1.92,0.4 -4.66,7.91 5.61,4.74 -3.8,0.23 -2.64,2.67 -1.65,4.66 -4.67,1.91 -2.49,-0.48 0.82,3.63 3.16,0.75 0.61,1.09 -1.38,2.12 -3.81,-0.05 -5.49,9.08 -2.48,0.94 -0.36,1.26 -1.16,0.99 -1.25,-0.21 -6.31,3.76 -1.84,3.26 -0.89,-0.29 -2.17,-0.03 -7.34,-0.81 -2.94,0.61 -6.34,-5.94 -1.66,-0.3 -2.5,-0.88 -3.28,3.32 -2.49,-0.64 -2.7,4.58 -1.26,-1.68 -2.11,0.47 -1.77,-1.5 -3.71,-1.64 -2.63,2.84 0.95,2.96 -0.34,0.16 -6.01,1.84 -5.15,3.59 -4.25,3.46 -2.78,2.74 -5.12,4.59 -0.32,-4 1.41,-1.84 -1.41,-4.49 z",

                        "d75" : "m 279.32,194.87 0.73,0.99 1.69,-3.11 1.15,0.46 5.23,-1.22 4.97,2.26 -0.42,4.98 -1.18,3.08 -6.3,-0.09 -1.74,-1.91 -2.54,-0.3 -4.27,-2.04 -3.41,1.35 -6.68,3.57 -2,0.15 -0.89,-0.89 -2.31,0.94 -3.08,-0.51 -4.54,-2.09 -3.28,-1.13 -3.05,-1.28 -2.18,-1.18 -2.3,0.93 -1.09,-2.08 -1.24,0.09 -2.36,-1.16 -1.38,-3.69 -6.09,-2.86 0.4,-2.29 1.59,-3.74 3.61,-2.84 2.45,0.84 1.23,-2.26 5.11,0.67 1.18,-2.73 4.98,-3.27 4.15,-2.42 2.59,-0.25 5.61,-0.1 3.58,-0 1.14,-0.01 4.91,0.23 1.79,1.94 0.53,2.64 0.42,2.21 2.64,2.07 0.65,2.09 0.47,6.98 0.24,2.31 0,0 0,0 -0.1,1.01 z",
                        "d77" : "m 396.25,459.98 -1.08,0.17 -4.24,5.25 -7.73,4.97 -4.81,-0.71 -0.76,-2.31 0.26,-6.3 2.61,-2.79 0.13,-1.26 -3.1,-1.55 -2.27,1.05 -2.41,-0.81 -2.01,1.55 -2.55,-0.32 -2.29,1.06 -4.74,-1.93 4.62,5.61 0.24,2.43 -8.52,3.17 -4.16,4.88 -8.08,-0.17 -2.07,1.74 -0.73,0.05 -6.49,-7.18 -9.21,2.73 -6.88,-0.02 -1.88,-3.52 -8.6,0.07 -4.13,4.68 0.12,1.25 -11.6,-1.58 -4.85,1.33 -0.81,0.86 -3.42,-0.84 0.42,-2.32 4.4,-2.59 2.89,-4 -0.05,-2.35 2.99,-3.84 5.98,3.18 2.25,-3.25 -1.54,-6.26 1.73,-4.68 1.27,-0.35 0.72,-1.88 -1.42,-6.08 -0.85,-0.01 0.35,-4.87 -2.07,-0.81 -0.28,-3.71 -5.71,-0.21 -1.69,-2.02 -0.2,-2.6 -1.99,-1.74 -4.5,1.86 -1.88,-1.59 -1.14,0.49 -2.44,-1.01 -2.31,-3.17 -0.41,-1.1 0.26,-12.65 -4.63,-8.38 -1.87,-1.97 -0.76,-3.94 2.31,1.13 4.86,-1.57 3.58,1.04 -0.87,-5.05 2.83,-3.75 -2.92,-1.89 2.91,-2.43 2.49,0.47 -0.19,-2.55 8.47,-3.34 -2.21,-3.1 3.18,-2.48 5.29,0.78 3.98,-3.52 6.54,1.06 -7.64,-10.25 -3.17,-0.87 -0.12,-7.08 -0.08,-2.05 -1.57,-1.54 0.44,-0.69 1.63,-0.81 -0.84,-8.98 2.05,-1.62 0.46,-2.7 0.48,-5.49 -1.22,-0.05 -0.56,-2.4 -2.39,-0.58 3.12,-9.85 -2.62,-0.13 4.85,-7.4 0.47,-2.51 3.08,-1.99 -2.53,0.15 -0.88,-3.9 6.01,-5.26 0.3,-4.63 -4.19,-2.45 -2.21,-5.76 1.01,-0.8 4.97,-0.72 0.48,-3.96 1.43,-2.18 -3.64,-2.99 3.56,-5.66 2.45,-0.36 2.12,1.38 2.45,-2.67 2.42,-0.34 -0.93,-4.8 -2.24,-1 1.56,-2.71 -0.85,-0.78 -1.41,-2.43 -0.17,-0.68 3.19,-5.43 3.69,-3.41 -1.75,-4.78 3.04,-2.58 -0.5,-3.82 4.44,-0.19 -2.13,-4.75 -3.96,0.36 -1,-0.9 3.04,-7.27 -1.86,-1.57 1.29,-3.38 -1.08,-0.54 0.92,-2.65 -2.4,-7.78 -3.15,-7.46 2.23,-1.08 1.25,-3.42 -4.97,-0.39 0.68,-4.94 -2.83,-2.62 1.82,-1.9 5.01,-1.88 -0.13,-2.58 1.54,-2.08 0.24,-0.21 -0.85,-0.89 0.88,-5.85 2.64,-1.67 -0.04,-2.32 -1.65,-1.29 -1.01,-4.18 -6.49,-10.11 -0.12,-1.34 2.56,-0.73 1.07,-2.45 -1.03,-5.2 -1.1,-0.49 -1.44,-4.23 -3.26,0.99 -0.61,-1.09 -3.16,-0.74 -0.82,-3.63 2.49,0.48 4.67,-1.91 1.65,-4.66 2.64,-2.67 3.8,-0.23 -5.61,-4.75 4.66,-7.9 4.1,-3.44 0.99,-2.48 2.3,0.2 3.58,-5.39 1.87,3.38 2.63,-0.2 6.96,5.68 3.53,3.58 -0.27,2.31 -0.29,1.19 3.33,1.11 5.46,-6.09 2.7,7.79 6.6,-0.97 6.26,-4.82 -4.32,-3.05 5.08,0.16 -1.07,-2.24 1.98,-0.58 4.48,-2.86 4.18,4.82 2.44,0.84 2.49,-0.73 2.84,5.78 4.05,-0.49 4.64,-2.8 1.24,0.57 1.68,-3.23 5.78,2.76 2.48,-0.66 1.03,0.78 1.2,-0.33 0.84,-3.59 2.3,0.83 3.19,-1.83 1.05,0.65 0.81,5.5 3.45,0.96 1.06,-4.6 2.99,-1.76 2.27,-0.8 4.53,1.55 0.99,-0.7 8.09,1.31 -2.39,-4.1 -0.11,-2.39 3.97,-6.08 1.9,1.87 8.99,2.16 1.74,-0.68 0.61,0.75 3.81,0.19 2.99,2.33 3.82,0.3 -2.4,5.51 0.74,1.98 2.35,1.36 3.55,5.72 -0.21,2.34 2.51,2.39 -0.01,1.27 -2.44,0.94 -1.1,5.05 -3.37,1.99 -0.12,2.45 2.2,2.89 7.02,2.59 2.22,2.45 0.44,2.21 3.58,1.29 0.4,1.21 1.11,-0.43 0.54,4.53 4.69,0.97 1.47,4.73 1.99,5.1 -0.69,1.61 1.28,2.22 1.11,0.62 3.66,-1.07 5.36,-3.37 1.93,5.19 0.24,5.52 4.41,5.14 8.05,-4.55 1.45,-3.6 2.02,7.78 -1.22,5.25 2.74,3 0.38,5.41 1.16,0.73 4.87,-1.63 -1.77,3.69 2.47,1.04 3.72,-1.52 1.41,2.28 6.09,2.06 -1.73,5.09 4.27,1.82 2.09,-4.71 3.84,-0.55 1.6,6.51 -1.53,3.76 0.53,4.01 -1.6,1.18 -1.58,-2.78 -1.19,-0.51 -6.59,3.5 -3.76,-0.45 -3.41,-1.85 -2.67,2.96 0.36,1.28 3.5,1.74 5.06,0.34 0.48,5.19 -0.11,1.28 -3.49,1.55 -2.22,-1.23 -2.55,0.16 -3.26,8.7 0.52,2.48 2.54,0.81 4.95,-1.69 2.15,1.54 0.08,3.88 1.54,2.09 6.34,-0.36 -0.14,3.83 0.12,2.3 0,6.75 2.79,2.92 -1.34,0.2 -0.41,3.95 -3.66,1.74 -3.56,4.04 0.91,2.18 -0.93,0.99 4.21,5.06 -1.95,6.48 6.61,-1.16 3.94,-3.69 6.64,1.17 3.94,-1.06 -3.7,3.84 0.65,1.18 5.14,1.34 3.75,3.8 0.03,1.29 -12.13,4.53 -0.76,1.06 2.53,4.57 -5.94,0.88 -1.75,3.26 -4.18,2.91 -0.9,1 4.4,8.01 -0.14,3.25 -2.34,0.56 -5.65,4.45 -3.67,0.07 -5.76,-1.88 -2.27,2.13 5.05,6.06 2.64,6.02 -0.06,2.57 -3.65,-0.17 -4.32,1.87 -5.06,3.12 3.43,3.83 -0.12,2.6 2.32,3.16 -0.37,5.32 -1.91,1.85 -0.97,3.76 4.9,1.49 -1.78,2.29 4.08,-0.02 0.06,2.5 -1.54,7.29 -3.77,-0.31 -3.91,-2.99 -2.53,0.08 -2.34,2.81 -0.59,6.28 -1.96,1.36 0.04,-2.56 -1.26,-0.06 -1.38,2.09 -2.53,0.04 -1.66,0.42 -3.48,-1.45 -1.26,-0.05 -0.3,1.21 -7.14,-3.26 -0.4,1.26 -2.44,-0.06 -5.46,5.16 -6.36,-1.98 -3.1,1.04 -2.6,1.33 -2.77,-2.01 -2.28,0.5 -1.03,-2.5 -2.38,-1.21 -1.14,2.2 -5.84,1.84 -1.29,-2.06 -4.5,1.55 -2.01,1.64 -2.91,5.79 -0.99,-0.81 -0.22,-2.39 -2.57,0.13 -2.14,-1.33 -3.6,1.21 -4.47,-0.9 -3.09,7.32 0.8,4.77 -6.45,8.4 3.06,2.6 -1.92,1.66 2.51,4.26 -1.29,3.8 4.92,1.48 1.01,8.6 -3.86,0.38 -5.16,10.35 -1.77,4.93 -2.3,1.2 -2.12,-1.04 -4.49,2.18 -0.19,3.58 -4.04,0.65 -5.37,5.32 0.4,6 0,0 0,0 -9.43,1.53 z",
                        "d78" : "m 148.03,345.6 -1.5,2.17 -5.27,0.03 -1.21,-0.27 -2.62,0.03 -2.1,-1.57 -3.57,-0.91 -2.03,-4.45 -1.13,-3.59 -6.22,0.34 -2.15,-0.8 -0.34,-2.41 -1.77,-1.77 0.71,-2.1 -2.46,-2.87 0.78,-2.5 -3.18,-5.85 -0.06,-5.42 2.99,-10.42 -2.35,0.4 -3.36,-3.79 -0.84,-3.69 -3.4,-1.61 -2.44,1 -7.58,-2.07 0.28,-1.26 -2.11,-1.48 4.3,-8.55 -0.73,-2.33 -6.09,-0.59 -0.62,1.11 -1.49,-1.41 1.97,-0.8 -2.23,-0.66 -4.1,1.93 -2.25,-3.09 -0.09,-2.54 -1.86,-1.66 0.56,-2.26 -2.72,-2.68 0.65,-2.48 -5.27,0.29 -3.85,-3.68 -1.23,-1.37 1.01,-6.21 1.37,-3.61 -7.44,-3.09 0.14,-3.2 3.22,-1.89 -1.78,-0.58 0.55,-0.83 6.59,-8.6 1.35,-0.25 0.66,-1.6 0.64,-3.44 -4.99,-4.58 -5.2,-1.15 -0.48,-1.66 1.24,-2.33 -2.64,-4.57 0.79,-9.18 2.81,-2.07 0.09,-1.16 -2.14,-4.9 3.3,-2.22 0.13,-1.34 -2.09,-1.62 -2.39,-0.49 1.55,-5.08 -2.75,-2.55 -3.19,-1.35 -0.21,1.16 -3.18,-3.24 4.62,-6.99 -6.35,-6.36 1.52,-1.57 -0.65,-1.94 -0.27,-1.07 -0.56,-1.26 -3.9,-1.31 -2.34,1.15 -1.45,-2.14 0.92,-2.4 -2.44,-3 -0.07,0 2.52,-4.82 -2.54,0.2 -1.41,-5.01 6.02,-4.79 -1.25,-0.08 -1.39,-2.08 -3.62,1.65 -4,-0.04 -1.92,1.69 -2.25,-5.51 2.39,-0.83 2.52,-5.57 -1.59,-1.64 0.82,-1.97 -1.32,-1.51 -3.54,-3.05 -0.32,-3.89 -2,-3.4 0.85,-2.49 -1,-0.86 3.7,-3.74 3.76,3.81 2.56,0.81 4.34,-2.78 2.57,-7.24 -0.61,-2.51 1.58,1.72 1.14,4.53 6.46,-1.45 3.62,0.85 2.99,-2.45 5.69,-2.21 2.5,-0.35 1.16,2.31 1.36,2.63 1.51,-1.04 6.8,-2.76 6.17,1.04 4.24,2.82 2.42,2.54 -0.97,3.39 7.54,4.68 2.23,-2.08 0.9,0.69 3.97,0.24 0.09,-2.66 2.11,-3.16 2.86,2.19 4.77,0.04 1.26,-0.11 1.35,-3.11 -0.7,-2.34 4.84,-1.55 2.1,-0.07 4.31,2.92 0.18,1.77 6.1,2.93 -3.75,9.32 2.02,1.42 0.75,3.74 -0.85,2.41 0.63,-0.05 1.77,-1.51 3.42,-0.53 0.47,-5.08 6.49,-5.9 1.41,0.87 -0.43,1.64 6.37,7.8 2.01,-1.33 2.39,0.31 0.53,1.07 2.58,-0.51 3.65,1.57 2.66,-0.64 3.27,4.29 0.69,0.72 4.04,4.07 0.74,-1.08 5.14,-0.38 4.62,-2.42 1.83,2.55 3.44,-5 5.86,2.25 3.46,-3.63 1.38,3.84 -1.4,5.34 1.48,2.29 6.43,1.22 3.49,1.84 2.19,3.22 0.76,3.79 -0.03,1.46 -1.3,2.5 8.36,1.47 0.02,3.53 -1.86,2.08 1.41,4.49 -1.41,1.84 0.32,4 -6.78,3.67 -1.28,1.25 -2.89,5.88 -2.07,3.77 0.84,2.52 -0.88,2.29 2.38,4.22 -2.53,0.39 -1.11,3.78 0.63,3.28 0.74,2.76 -0.2,0.99 2.68,2.39 3.97,-0.44 2.31,5.54 -0.78,1 5.06,-0.41 1.65,1.91 0.2,2.53 3.63,1.04 0.61,1.12 -0.04,2.13 0.15,1.31 -1.11,0.7 -3.91,0.21 -1.77,-1.7 -2.59,-0.19 -0.79,0.97 1.21,3.47 -0.8,3.68 -3.65,-1.34 -3.49,1.92 -2.68,-0.09 -3.21,2.31 -0.03,1.35 -1.03,2.31 -4.41,-1.69 -3.38,1.28 -1.09,0.76 2.53,4.59 -0.75,2.55 0.66,1.3 -3.44,5.35 0.14,2.53 -2.17,-1.58 -1.92,4.87 -3.15,-1.39 -0.85,0.78 -2.79,0.01 -2.53,-0.03 -0.87,2.36 -1.27,0.17 -1.04,0.59 -1.29,5.79 -0.5,2.37 -3.55,-0.8 -0.44,2.33 2.16,4.49 3.73,0.3 0.24,3.72 1.46,1.95 0.26,0.21 3.81,3.59 -0.75,3.6 -5.12,1.15 -0.54,2.58 0.65,3.63 -3.62,4.12 -1.22,7.98 -8.93,0.19 -0.87,0.96 -4.35,-2.45 -6.37,-0.59 -1.06,5.09 7.14,5.4 3.62,0.21 0.27,2.6 -2.48,0.61 -0.97,-0.64 -2.86,1.66 -4.95,10.71 -0.38,5.57 -2.56,0.86 -1.69,2.09 -0.13,4.04 1.42,2.24 0,0 0,0 -0.64,3.74 z",
                        "d91" : "m 266.47,400.21 -0.57,-1.01 -2.11,0.94 -0.98,-0.64 -6.29,-6.27 -0.5,-2.49 -3.15,0.47 -1.24,0.55 -3.23,7.31 -2.21,0.78 -5.84,-2.34 -3.75,5.26 -2.52,1.15 0.86,-6.61 -2.63,-0.4 2.19,-5.26 -3.76,0.04 -4.41,-2.73 -1.94,-3.24 -6.38,8.12 -0.38,3.92 -2.76,-0.52 -0.48,0.91 -3.7,-0.75 -0.25,2.38 2.06,2.27 -0.1,1.63 -13.23,0.43 0.85,-3.99 -2.58,0.13 -4.27,4.74 -9.03,-0.48 -0.35,2.04 -2.15,1.55 -3.68,-1 -5.13,1.22 -3.93,-0.54 -3.87,-0.69 -4.4,-5.74 -0.67,-2.28 4.52,-2.12 -0.2,-3.56 1.77,-1.87 -2.98,-4.58 1.38,-6.55 3.07,-2.65 -2.6,-6.01 -2.66,-0.51 2.82,-7.25 -3.86,-2.06 -3.51,-0.83 -4.72,0.86 -0.13,-2.98 -0.99,-0.45 3.44,-3.61 -0.37,-5.17 1.48,-2.14 -2.26,-0.68 -0.85,-4.3 -2.17,-1.54 -1.42,-2.24 0.13,-4.04 1.69,-2.09 2.56,-0.86 0.38,-5.57 4.95,-10.71 2.86,-1.66 0.97,0.64 2.48,-0.61 -0.27,-2.6 -3.62,-0.21 -7.14,-5.4 1.06,-5.09 6.37,0.59 4.35,2.45 0.87,-0.96 8.93,-0.19 1.22,-7.98 3.62,-4.12 -0.65,-3.63 0.54,-2.58 5.12,-1.15 0.75,-3.6 -3.81,-3.59 -0.26,-0.21 -1.46,-1.95 -0.24,-3.72 -3.73,-0.3 -2.16,-4.49 0.44,-2.33 3.55,0.8 0.5,-2.37 1.29,-5.79 1.04,-0.59 1.27,-0.17 0.87,-2.36 2.53,0.03 2.79,-0.01 0.85,-0.78 3.15,1.39 1.92,-4.87 2.18,1.58 -0.14,-2.53 3.44,-5.35 -0.66,-1.3 0.75,-2.55 -2.53,-4.59 1.09,-0.76 3.38,-1.28 4.41,1.69 1.03,-2.31 0.03,-1.35 3.21,-2.31 2.68,0.09 3.49,-1.92 3.65,1.34 0.8,-3.68 -1.21,-3.47 0.79,-0.97 2.59,0.19 1.77,1.7 3.91,-0.21 1.11,-0.7 -0.15,-1.31 0.58,0.64 1,3.31 4.4,1.9 4.94,0.27 1.75,1.56 1.91,3.35 -2.39,2.84 0.98,2.41 1.29,0.17 4.82,-2.01 0.41,3.86 2.48,-0.38 1.92,-7.07 0.81,-0.72 1.77,1 2.47,2.78 3.47,0.94 4.11,-2.84 0.1,7.07 0.05,2.99 4.08,0.06 6.3,-2.27 0.81,3.21 5.38,-2.4 1.29,-0.51 0.69,1.85 2.12,2.27 -0.32,-2.52 3.34,-2.16 2.63,-0.22 0.62,-0.01 2.36,-0.56 6.57,-2.13 2.85,8.71 2.1,2.39 -0.7,0.56 1.07,1.93 3.4,0.54 1.19,3.67 5.84,-1.13 2.24,1 0.93,4.8 -2.42,0.34 -2.45,2.67 -2.12,-1.38 -2.45,0.36 -3.56,5.66 3.64,2.99 -1.43,2.18 -0.48,3.96 -4.97,0.72 -1.01,0.8 2.21,5.76 4.19,2.45 -0.3,4.63 -6.01,5.26 0.88,3.9 2.53,-0.15 -3.08,1.99 -0.47,2.51 -4.85,7.4 2.62,0.13 -3.12,9.85 2.39,0.58 0.56,2.4 1.22,0.05 -0.48,5.49 -0.46,2.7 -2.05,1.62 0.84,8.98 -1.63,0.81 -0.44,0.69 1.57,1.54 0.08,2.05 0.12,7.08 3.17,0.87 7.64,10.25 -6.54,-1.06 -3.98,3.52 -5.29,-0.78 -3.18,2.48 2.21,3.1 -8.47,3.34 0.19,2.55 -2.49,-0.47 -2.91,2.43 2.92,1.89 -2.83,3.75 0.87,5.05 -3.58,-1.04 -4.86,1.57 -2.31,-1.13 0.76,3.94 1.87,1.97 0,0 0,0 -0.98,2.12 z",
                        "d92" : "m 250.77,236.52 -0.41,-3.86 -4.82,2.01 -1.29,-0.17 -0.98,-2.41 2.39,-2.84 -1.91,-3.35 -1.75,-1.56 -4.94,-0.27 -4.4,-1.9 -1,-3.31 -0.58,-0.64 0.04,-2.13 -0.61,-1.12 -3.63,-1.04 -0.2,-2.53 -1.65,-1.91 -5.06,0.41 0.78,-1 -2.3,-5.54 -3.98,0.44 -2.68,-2.39 0.2,-0.99 -0.74,-2.76 -0.63,-3.28 1.11,-3.78 2.53,-0.39 -2.38,-4.22 0.88,-2.29 -0.84,-2.52 2.07,-3.77 2.89,-5.88 1.28,-1.25 6.78,-3.67 5.12,-4.59 2.78,-2.74 4.25,-3.46 5.15,-3.59 6.01,-1.84 5.29,1.22 5.93,2.54 0.24,3.88 -1.96,3.41 -1.66,1.58 -0.57,1.06 -1.56,0.73 1.52,5.29 -4.15,2.42 -4.98,3.27 -1.18,2.73 -5.11,-0.67 -1.23,2.26 -2.45,-0.84 -3.61,2.84 -1.59,3.74 -0.4,2.29 6.09,2.86 1.38,3.69 2.36,1.16 1.24,-0.09 1.09,2.08 2.3,-0.93 2.18,1.18 3.05,1.28 3.28,1.13 4.54,2.09 -0.74,1.25 -2.58,1.46 1.22,3.28 -1.4,5.26 1.81,2.38 -1.55,4.34 -1.05,1.53 -1.6,4.72 2.78,2.29 0,0 0,0 -1.92,7.07 z",
                        "d93" : "m 319.02,202.49 0.06,-2.38 -8.19,-5.53 0.14,-1.34 -5.5,-3.7 -0.51,0.47 -2.48,-2.76 -1.09,0.6 -0.84,-1.65 -3.81,-0.61 -7,2.28 -1.86,1.65 -2.52,-0.65 -2.08,1.51 -2.62,-0.2 -0.68,0.03 -0.24,-2.31 -0.47,-6.98 -0.65,-2.09 -2.64,-2.07 -0.42,-2.21 -0.53,-2.64 -1.79,-1.94 -4.91,-0.23 -1.14,0.01 -3.58,0 -5.61,0.1 -2.59,0.25 -1.52,-5.29 1.56,-0.73 0.57,-1.06 1.66,-1.58 1.96,-3.41 -0.24,-3.88 -5.93,-2.54 -5.29,-1.22 0.34,-0.16 -0.95,-2.96 2.63,-2.84 3.71,1.64 1.77,1.5 2.11,-0.47 1.26,1.68 2.7,-4.58 2.49,0.64 3.28,-3.32 2.5,0.88 1.66,0.3 6.34,5.94 2.94,-0.61 7.34,0.81 2.18,0.03 0.89,0.29 1.84,-3.25 6.31,-3.76 1.25,0.21 1.16,-0.99 0.36,-1.26 2.48,-0.94 5.49,-9.08 3.81,0.05 1.39,-2.12 3.26,-0.99 1.44,4.23 1.1,0.49 1.03,5.2 -1.07,2.45 -2.56,0.73 0.12,1.34 6.49,10.11 1.01,4.18 1.65,1.29 0.04,2.32 -2.64,1.67 -0.88,5.85 0.85,0.89 -0.24,0.21 -1.54,2.08 0.13,2.58 -5.01,1.88 -1.82,1.9 2.83,2.62 -0.68,4.94 4.97,0.39 -1.25,3.42 -2.23,1.08 3.15,7.46 2.4,7.78 -0.92,2.65 0,0 0,0 -5.69,-3.01 z",
                        "d94" : "m 312.54,249.04 -3.4,-0.54 -1.07,-1.93 0.7,-0.56 -2.1,-2.39 -2.85,-8.71 -6.57,2.13 -2.36,0.56 -0.62,0.01 -2.63,0.22 -3.34,2.16 0.32,2.52 -2.12,-2.27 -0.69,-1.85 -1.29,0.51 -5.38,2.4 -0.81,-3.21 -6.3,2.27 -4.08,-0.06 -0.05,-2.99 -0.1,-7.07 -4.11,2.84 -3.47,-0.94 -2.47,-2.78 -1.77,-1 -0.81,0.72 -2.78,-2.29 1.6,-4.72 1.05,-1.53 1.55,-4.34 -1.81,-2.38 1.4,-5.26 -1.22,-3.28 2.58,-1.46 0.74,-1.25 3.08,0.51 2.31,-0.94 0.89,0.89 2,-0.15 6.68,-3.57 3.41,-1.35 4.27,2.04 2.54,0.3 1.74,1.91 6.3,0.09 1.18,-3.08 0.42,-4.98 -4.97,-2.26 -5.23,1.22 -1.15,-0.46 -1.69,3.11 -0.73,-0.99 0.62,-3.65 0.1,-1.01 0.68,-0.03 2.62,0.2 2.08,-1.51 2.52,0.65 1.86,-1.65 7,-2.28 3.81,0.61 0.84,1.65 1.09,-0.6 2.48,2.76 0.51,-0.47 5.5,3.7 -0.14,1.34 8.19,5.53 -0.06,2.38 0.4,1.23 5.69,3.01 1.08,0.54 -1.29,3.38 1.86,1.57 -3.04,7.27 1,0.9 3.96,-0.36 2.13,4.75 -4.44,0.19 0.5,3.82 -3.04,2.58 1.75,4.78 -3.69,3.41 -3.19,5.43 0.17,0.68 1.41,2.43 0.85,0.78 -1.56,2.71 0,0 0,0 -5.84,1.13 z",
                        "d95" : "m 225.86,160.67 -1.41,-4.49 1.86,-2.08 -0.03,-3.53 -8.36,-1.47 1.3,-2.5 0.03,-1.45 -0.76,-3.79 -2.19,-3.22 -3.49,-1.84 -6.43,-1.22 -1.48,-2.29 1.4,-5.34 -1.38,-3.84 -3.45,3.63 -5.86,-2.25 -3.44,5 -1.83,-2.55 -4.62,2.42 -5.14,0.39 -0.74,1.08 -4.04,-4.07 -0.69,-0.72 -3.27,-4.29 -2.66,0.64 -3.65,-1.57 -2.58,0.51 -0.53,-1.07 -2.38,-0.32 -2.01,1.33 -6.37,-7.8 0.43,-1.64 -1.41,-0.87 -6.49,5.9 -0.47,5.08 -3.42,0.53 -1.77,1.51 -0.63,0.05 0.85,-2.41 -0.75,-3.74 -2.02,-1.42 3.75,-9.32 -6.1,-2.93 -0.18,-1.77 -4.31,-2.92 -2.1,0.07 -4.84,1.55 0.7,2.34 -1.35,3.11 -1.26,0.11 -4.77,-0.04 -2.86,-2.19 -2.11,3.16 -0.09,2.66 -3.97,-0.24 -0.9,-0.69 -2.23,2.08 -7.54,-4.68 0.97,-3.38 -2.42,-2.54 -4.24,-2.82 -6.17,-1.04 -6.8,2.76 -1.51,1.04 -1.36,-2.64 3.77,-3.12 -0.98,-0.75 0.24,-3.5 1.81,-3.14 5.51,-7.65 2.05,-2.05 -0.61,-4.51 2.47,-4.06 0.42,-0.56 -0.71,-1.12 2.09,-4.8 -0.72,-2.54 1.43,-1.99 -0.27,-3.51 1.44,-3.7 -0.66,-2.4 0.83,-2.54 6.02,-5.32 1.26,-2.35 1.67,-1.99 7.46,5.54 -1.2,0.56 -0.53,3.87 -4.72,2.16 -0.03,1.32 2.35,0.95 0.22,2.53 3.31,0.76 0.88,4.83 3.4,1.97 5.22,-3.89 0.14,-0.05 4.22,1.99 1.1,-1.88 4.85,3.68 3.64,-0.38 1.34,2.13 -0.69,2.49 3.86,-2.03 6.5,-1.38 0.58,-0.39 1.41,5 13.15,-4.04 0.88,1.02 2.7,-0 3.76,-1.41 2.95,-3.35 6.43,3.09 5.76,-5.03 4.21,-1.29 0.04,-0.1 3.12,-2.44 4.96,-1.72 2.84,-2.73 -0.05,1.26 2.41,0.71 1.37,6 5.1,0.86 3.67,-1.03 2.39,2.99 0.9,-0.93 2.48,0.66 2.62,2.48 -1.47,1.97 1.55,2.51 1.1,0.54 2.85,-2.28 -0.68,-2.29 2.74,1.32 5.06,-0.58 3.36,-1.66 3.3,5.19 -4.4,4.45 6.42,1.15 3.53,-0.78 1.75,-1.78 1.09,0.74 5.08,-1.31 0.63,-3.8 2.77,-2.87 0.45,-2.62 2.4,-0.36 2.85,0.2 9.45,14.5 3.57,-4.63 5.47,3.76 4,-0.87 7.77,2.5 -0.52,1.67 -0.92,2.93 5.37,-2.36 1.19,0.17 0.05,1.2 4.14,2.18 -0.16,1.2 5.66,2.26 0.43,2.32 -2.84,3.85 10.49,2.7 0.77,-7.58 2.25,-1.14 -0.14,1.25 2.44,-0.69 0.73,0.87 1.22,8.09 4.37,2.03 1.61,4.59 1.92,0.4 -4.66,7.91 5.61,4.74 -3.8,0.23 -2.64,2.67 -1.65,4.66 -4.67,1.91 -2.49,-0.48 0.82,3.63 3.16,0.75 0.61,1.09 -1.38,2.12 -3.81,-0.05 -5.49,9.08 -2.48,0.94 -0.36,1.26 -1.16,0.99 -1.25,-0.21 -6.31,3.76 -1.84,3.26 -0.89,-0.29 -2.17,-0.02 -7.34,-0.81 -2.94,0.61 -6.34,-5.94 -1.66,-0.3 -2.5,-0.88 -3.28,3.32 -2.49,-0.64 -2.7,4.58 -1.26,-1.67 -2.11,0.47 -1.77,-1.5 -3.71,-1.64 -2.63,2.84 0.95,2.96 -0.34,0.16 -6.01,1.84 -5.15,3.59 -4.25,3.46 -2.78,2.74 -5.12,4.59 -0.32,-4 z",
                    }
                }
            }
        }
    );
})(jQuery);
