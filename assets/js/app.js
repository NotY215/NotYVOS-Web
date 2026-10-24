document.addEventListener('DOMContentLoaded',()=>{const toggle=document.querySelector('.menu-toggle'),nav=document.querySelector('.main-nav');if(toggle&&nav){const home=nav.parentNode,marker=document.createComment('mobile-navigation-placeholder');nav.parentNode.insertBefore(marker,nav);let backdrop=document.querySelector('.nav-backdrop');if(!backdrop){backdrop=document.createElement('div');backdrop.className='nav-backdrop';backdrop.setAttribute('aria-hidden','true');document.body.appendChild(backdrop)}const mobile=()=>window.matchMedia('(max-width:760px)').matches;const setMenu=(open)=>{if(mobile()&&nav.parentNode!==document.body){document.body.appendChild(nav);nav.classList.add('mobile-drawer')}if(open&&mobile()){document.body.classList.add('nav-drawer-open');backdrop.classList.add('open')}else{document.body.classList.remove('nav-drawer-open');backdrop.classList.remove('open')}nav.classList.toggle('open',open);toggle.setAttribute('aria-expanded',String(open));toggle.setAttribute('aria-label',open?'Close navigation':'Open navigation');if(!open&&nav.parentNode===document.body){nav.classList.remove('mobile-drawer');marker.parentNode.insertBefore(nav,marker.nextSibling)}};toggle.setAttribute('aria-controls',nav.id||'main-nav');toggle.addEventListener('click',()=>setMenu(toggle.getAttribute('aria-expanded')!=='true'));backdrop.addEventListener('click',()=>setMenu(false));nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));document.addEventListener('keydown',e=>{if(e.key==='Escape'&&toggle.getAttribute('aria-expanded')==='true'){setMenu(false);toggle.focus()}});window.addEventListener('resize',()=>{if(!mobile()){setMenu(false);if(nav.parentNode!==home){nav.classList.remove('mobile-drawer');marker.parentNode.insertBefore(nav,marker.nextSibling)}}else if(nav.parentNode!==document.body&&toggle.getAttribute('aria-expanded')==='true'){document.body.appendChild(nav);nav.classList.add('mobile-drawer')}});if(mobile()){nav.classList.remove('open');nav.style.removeProperty('display')}}const observer=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');observer.unobserve(e.target)}}),{threshold:.12});document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));document.querySelectorAll('.faq-item summary').forEach(s=>s.addEventListener('click',()=>{const item=s.parentElement;document.querySelectorAll('.faq-item[open]').forEach(other=>{if(other!==item)other.removeAttribute('open')})}));document.addEventListener('contextmenu',e=>e.preventDefault());document.addEventListener('keydown',e=>{if(e.key==='F12'||(e.ctrlKey&&e.shiftKey&&['I','J','C'].includes(e.key.toUpperCase()))||(e.ctrlKey&&e.key.toUpperCase()==='U'))e.preventDefault()})});

/* Lightweight PS3 face-button ambient animation shared across the site. */
document.addEventListener('DOMContentLoaded',()=>{
  if(window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;
  let field=document.querySelector('.ps3-symbol-field');
  if(!field){
    field=document.createElement('div');
    field.className='ps3-symbol-field';
    field.setAttribute('aria-hidden','true');
    document.body.appendChild(field);
  }
  if(field.dataset.ready==='true')return;
  field.dataset.ready='true';
  const symbols=[
    {glyph:'△',color:'#42c5ff'},{glyph:'○',color:'#f06a91'},
    {glyph:'×',color:'#55d9c5'},{glyph:'□',color:'#b48aff'}
  ];
  const count=window.innerWidth<700?10:18;
  for(let i=0;i<count;i++){
    const data=symbols[i%symbols.length];
    const el=document.createElement('span');
    el.className='ps3-symbol';
    el.textContent=data.glyph;
    el.style.setProperty('--symbol-color',data.color);
    el.style.setProperty('--x',((i*37+9)%97)+'%');
    el.style.setProperty('--y',((i*53+5)%100)+'%');
    el.style.setProperty('--size',(24+(i*13)%43)+'px');
    el.style.setProperty('--duration',(13+(i*7)%15)+'s');
    el.style.setProperty('--delay',(-((i*11)%25))+'s');
    el.style.setProperty('--drift-x',(((i*29)%100)-50)+'px');
    el.style.setProperty('--peak-opacity',String(.13+((i*17)%20)/100));
    field.appendChild(el);
  }
});
