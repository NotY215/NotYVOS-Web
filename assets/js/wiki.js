(function(){
'use strict';
const input=document.getElementById('wiki-search-input');
const clear=document.getElementById('wiki-search-clear');
const count=document.getElementById('wiki-search-count');
const results=document.getElementById('wiki-search-results');
const chapters=Array.from(document.querySelectorAll('.wiki-chapter'));
const navLinks=Array.from(document.querySelectorAll('.wiki-index nav a'));
const progress=document.getElementById('wiki-reading-progress');
if(!chapters.length)return;
const normalize=function(s){return String(s||'').toLocaleLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z0-9]+/g,' ').trim();};
const entries=chapters.map(function(el){return {el:el,id:el.id,title:el.querySelector('h2')?.textContent?.trim()||el.id,text:normalize(el.innerText+' '+(el.dataset.keywords||''))};});
function search(){
 const raw=input?input.value.trim():'';
 const terms=normalize(raw).split(/\s+/).filter(Boolean);
 let visible=0,matches=[];
 entries.forEach(function(item){
  const ok=!terms.length||terms.every(function(term){return item.text.includes(term);});
  item.el.hidden=!ok;
  if(ok){visible++;if(terms.length)matches.push(item);}
 });
 if(count)count.textContent=terms.length?visible+' of '+entries.length+' chapters match “'+raw+'”.':'All '+entries.length+' Wiki chapters are visible.';
 if(results){results.hidden=!terms.length;results.innerHTML=matches.slice(0,8).map(function(x){return '<a href="#'+x.id+'">'+x.title+'<span>Open chapter ↗</span></a>';}).join('')||'<p>No matching chapters. Try a broader term such as runtime, graphics or tests.</p>';}
 navLinks.forEach(function(a){const item=entries.find(function(x){return x.id===a.getAttribute('href').slice(1);});if(item)a.hidden=item.el.hidden;});
}
if(input)input.addEventListener('input',search);
if(clear)clear.addEventListener('click',function(){if(input){input.value='';search();input.focus();}});
document.addEventListener('keydown',function(e){
 if(e.key==='/'&&!/INPUT|TEXTAREA/.test(document.activeElement?.tagName||'')){e.preventDefault();if(input)input.focus();}
 if(e.key==='Escape'&&document.activeElement===input){if(input.value){input.value='';search();}else input.blur();}
});
document.querySelectorAll('[data-copy]').forEach(function(btn){btn.addEventListener('click',async function(){
 const value=btn.dataset.copy||'';
 try{await navigator.clipboard.writeText(value);btn.textContent='Copied';setTimeout(function(){btn.textContent='Copy';},1200);}
 catch(_){btn.textContent='Copy unavailable';setTimeout(function(){btn.textContent='Copy';},1400);}
});});
const updateProgress=function(){const max=document.documentElement.scrollHeight-innerHeight;const pct=max>0?Math.min(100,Math.round(scrollY/max*100)):0;if(progress)progress.textContent=pct+'%';};
addEventListener('scroll',updateProgress,{passive:true});addEventListener('resize',updateProgress);updateProgress();
if('IntersectionObserver'in window){const io=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting)navLinks.forEach(function(a){a.classList.toggle('active',a.hash==='#'+entry.target.id);});});},{rootMargin:'-18% 0px -70% 0px'});chapters.forEach(function(c){io.observe(c);});}
search();
})();