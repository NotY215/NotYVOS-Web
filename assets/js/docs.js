import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@12.1.0/+esm';
import { Chart } from 'https://cdn.jsdelivr.net/npm/chart.js@4.5.1/+esm';
import { Grid } from 'https://cdn.jsdelivr.net/npm/gridjs@6.2.0/+esm';
import gsap from 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/index.js';
import cytoscape from 'https://cdn.jsdelivr.net/npm/cytoscape@3.34.3/+esm';

const root=document.querySelector('.docs-war');
const content=document.querySelector('#docs-content');
const links=[...document.querySelectorAll('.docs-link')];
const search=document.querySelector('#docs-search');
const progress=document.querySelector('#docs-progress');

mermaid.initialize({
 startOnLoad:false,
 securityLevel:'strict',
 theme:'base',
 themeVariables:{
  background:'#05080d',
  primaryColor:'#162538',
  primaryTextColor:'#eaf7ff',
  primaryBorderColor:'#39c7ff',
  lineColor:'#d7a93b',
  secondaryColor:'#321a20',
  tertiaryColor:'#0b1724',
  fontFamily:'Inter, system-ui, sans-serif'
 }
});

async function diagrams(){
 const nodes=[...document.querySelectorAll('.mermaid')];
 for(const node of nodes){
  const source=node.textContent.trim();
  const id='notyvos-'+Math.random().toString(36).slice(2);
  try{
   const result=await mermaid.render(id,source);
   node.outerHTML='<div class="mermaid-output">'+result.svg+'</div>';
  }catch(error){
   node.outerHTML='<div class="diagram-error">Diagram failed to render: '+String(error)+'</div>';
  }
 }
}

function sectionLinks(){
 links.forEach(button=>button.addEventListener('click',()=>{
  document.getElementById(button.dataset.section)?.scrollIntoView({behavior:'smooth',block:'start'});
 }));
 document.querySelectorAll('[data-jump]').forEach(button=>button.addEventListener('click',()=>{
  document.getElementById(button.dataset.jump)?.scrollIntoView({behavior:'smooth',block:'start'});
 }));
}

function observer(){
 const sections=[...document.querySelectorAll('.docs-section')];
 const io=new IntersectionObserver(entries=>{
  entries.forEach(entry=>{
   if(!entry.isIntersecting)return;
   links.forEach(x=>x.classList.toggle('active',x.dataset.section===entry.target.id));
  });
 },{rootMargin:'-18% 0px -65% 0px'});
 sections.forEach(s=>io.observe(s));
 window.addEventListener('scroll',()=>{
  const max=document.documentElement.scrollHeight-innerHeight;
  progress.textContent=(max>0?Math.round(scrollY/max*100):0)+'%';
 },{passive:true});
}

function filter(){
 search?.addEventListener('input',()=>{
  const q=search.value.trim().toLowerCase();
  links.forEach(button=>{
   const section=document.getElementById(button.dataset.section);
   const match=!q||button.textContent.toLowerCase().includes(q)||(section?.textContent||'').toLowerCase().includes(q);
   button.hidden=!match;
  });
 });
}

function charts(){
 const canvas=document.querySelector('#roadmap-chart');
 if(!canvas)return;
 const labels=['Kernel','Memory','Scheduler','NYFS','Graphics','RSX','PPU/SPU/DMA/JIT','Desktop UI','Decoders','SVG/Icons','TrueType'];
 const values=[92,95,85,55,85,65,70,70,90,85,75];
 new Chart(canvas,{type:'bar',data:{labels,datasets:[{label:'Implementation level',data:values,borderWidth:1}]},options:{responsive:true,maintainAspectRatio:false,indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{beginAtZero:true,max:100,ticks:{callback:v=>v+'%'}},y:{grid:{display:false}}}}});
}

function tableEnhancement(){
 const tables=[...document.querySelectorAll('.docs-table')];
 tables.forEach(table=>{
  const headers=[...table.querySelectorAll('thead th')].map(x=>x.textContent.trim());
  const rows=[...table.querySelectorAll('tbody tr')].map(row=>[...row.children].map(x=>x.textContent.trim()));
  const host=document.createElement('div');
  host.className='docs-grid-table';
  table.replaceWith(host);
  new Grid({columns:headers,data:rows,search:true,sort:true,pagination:{limit:8}}).render(host);
 });
}

function liveGraph(){
 const host=document.querySelector('.docs-final');
 if(!host)return;
 const graph=document.createElement('div');
 graph.className='docs-mini-graph';
 graph.innerHTML='<div class="graph-label">LIVE SUBSYSTEM MAP</div><div id="docs-cyto"></div>';
 host.before(graph);
 const cy=cytoscape({
  container:graph.querySelector('#docs-cyto'),
  elements:[
   {data:{id:'kernel',label:'KERNEL'}},{data:{id:'memory',label:'MEMORY'}},{data:{id:'sched',label:'SCHEDULER'}},
   {data:{id:'vfs',label:'VFS'}},{data:{id:'nyfs',label:'NYFS'}},{data:{id:'gfx',label:'GRAPHICS'}},
   {data:{id:'desktop',label:'DESKTOP'}},{data:{id:'game',label:'GAMERUNNER'}},{data:{id:'rsx',label:'RSX'}},
   {data:{source:'kernel',target:'memory'}},{data:{source:'kernel',target:'sched'}},{data:{source:'kernel',target:'vfs'}},
   {data:{source:'vfs',target:'nyfs'}},{data:{source:'kernel',target:'gfx'}},{data:{source:'gfx',target:'desktop'}},
   {data:{source:'kernel',target:'game'}},{data:{source:'game',target:'rsx'}},{data:{source:'rsx',target:'gfx'}}
  ],
  style:[
   {selector:'node',style:{label:'data(label)',color:'#eaf7ff','background-color':'#12324a','border-color':'#39c7ff','border-width':2,'font-size':10,'text-valign':'center','text-halign':'center','width':'label','height':'label','padding':'10px','shape':'roundrectangle'}},
   {selector:'edge',style:{width:2,'line-color':'#8f6d24','target-arrow-color':'#8f6d24','target-arrow-shape':'triangle','curve-style':'bezier'}}
  ],
  layout:{name:'cose',animate:true,padding:40}
 });
 graph.addEventListener('click',()=>cy.layout({name:'cose',animate:true,padding:40}).run());
}

function particles(){
 const canvas=document.createElement('canvas');
 canvas.className='docs-particles';
 root.prepend(canvas);
 const ctx=canvas.getContext('2d');
 let w=0,h=0;
 const points=Array.from({length:70},()=>({x:Math.random(),y:Math.random(),vx:(Math.random()-.5)*.00035,vy:(Math.random()-.5)*.00035,r:Math.random()*1.6+.4}));
 const resize=()=>{w=canvas.width=innerWidth*devicePixelRatio;h=canvas.height=innerHeight*devicePixelRatio;canvas.style.width=innerWidth+'px';canvas.style.height=innerHeight+'px';ctx.setTransform(devicePixelRatio,0,0,devicePixelRatio,0,0)};
 addEventListener('resize',resize);resize();
 const draw=()=>{
  ctx.clearRect(0,0,innerWidth,innerHeight);
  for(const p of points){p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>1)p.vx*=-1;if(p.y<0||p.y>1)p.vy*=-1;ctx.beginPath();ctx.arc(p.x*innerWidth,p.y*innerHeight,p.r,0,Math.PI*2);ctx.fillStyle='rgba(57,199,255,.42)';ctx.fill();}
  requestAnimationFrame(draw);
 };
 draw();
}

function animations(){
 gsap.from('.docs-hero-inner',{opacity:0,y:35,duration:1.1,ease:'power3.out'});
 gsap.from('.docs-hero-card',{opacity:0,y:24,stagger:.12,duration:.8,delay:.35,ease:'power2.out'});
 document.querySelectorAll('.docs-section').forEach(section=>{
  gsap.from(section,{opacity:0,y:22,duration:.65,scrollTrigger:undefined});
 });
}

sectionLinks();observer();filter();charts();tableEnhancement();liveGraph();particles();animations();diagrams();
