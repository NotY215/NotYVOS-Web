document.addEventListener('DOMContentLoaded',()=>{
 const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;
 // Mobile navigation drawer, backdrop, Escape handling and focus-safe close behavior.
 const toggle=document.querySelector('.menu-toggle'),nav=document.querySelector('.main-nav');
 if(toggle&&nav){const marker=document.createComment('navigation-placeholder');nav.parentNode.insertBefore(marker,nav);let backdrop=document.querySelector('.nav-backdrop');if(!backdrop){backdrop=document.createElement('div');backdrop.className='nav-backdrop';backdrop.setAttribute('aria-hidden','true');document.body.appendChild(backdrop)}const mobile=()=>matchMedia('(max-width:760px)').matches;const open=()=>{if(!mobile())return;document.body.appendChild(nav);nav.classList.add('mobile-drawer','open');backdrop.classList.add('open');document.body.classList.add('nav-drawer-open');toggle.setAttribute('aria-expanded','true');toggle.setAttribute('aria-label','Close navigation')};const close=()=>{nav.classList.remove('open','mobile-drawer');backdrop.classList.remove('open');document.body.classList.remove('nav-drawer-open');toggle.setAttribute('aria-expanded','false');toggle.setAttribute('aria-label','Open navigation');if(marker.parentNode)marker.parentNode.insertBefore(nav,marker.nextSibling)};toggle.addEventListener('click',()=>toggle.getAttribute('aria-expanded')==='true'?close():open());backdrop.addEventListener('click',close);nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',close));document.addEventListener('keydown',e=>{if(e.key==='Escape'&&toggle.getAttribute('aria-expanded')==='true'){close();toggle.focus()}});window.addEventListener('resize',()=>{if(!mobile()&&toggle.getAttribute('aria-expanded')==='true')close()});}
 // Scroll-reveal animations; fully disabled when reduced motion is requested.
 const els=document.querySelectorAll('.reveal');if(reduce||!('IntersectionObserver'in window)){els.forEach(e=>e.classList.add('is-visible'))}else{const io=new IntersectionObserver(es=>es.forEach(x=>{if(x.isIntersecting){x.target.classList.add('is-visible');io.unobserve(x.target)}}),{threshold:.08,rootMargin:'0px 0px -25px 0px'});els.forEach((e,i)=>{e.style.transitionDelay=(i%4*55)+'ms';io.observe(e)})}
 // Wikipedia game search: article summaries only, never compatibility ratings.
 const form=document.querySelector('#game-search-form');if(form){const input=document.querySelector('#game-search-input'),status=document.querySelector('#game-search-status'),results=document.querySelector('#game-search-results'),detail=document.querySelector('#game-detail');const esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));const get=async p=>{const u=new URL('https://en.wikipedia.org/w/api.php');Object.entries({...p,origin:'*',format:'json'}).forEach(([k,v])=>u.searchParams.set(k,v));const r=await fetch(u.toString(),{headers:{Accept:'application/json'}});if(!r.ok)throw Error('Wikipedia request failed');return r.json()};form.addEventListener('submit',async e=>{e.preventDefault();const q=input.value.trim();if(q.length<2)return;status.textContent='Searching Wikipedia…';results.innerHTML='';detail.hidden=true;detail.innerHTML='';try{const d=await get({action:'query',generator:'search',gsrsearch:q+' (video game OR PlayStation 3)',gsrnamespace:0,gsrlimit:10,prop:'extracts|pageimages|info',exintro:1,explaintext:1,exchars:420,piprop:'thumbnail',pithumbsize:220,inprop:'url'});const ps=Object.values(d.query?.pages||{}).sort((a,b)=>a.index-b.index);if(!ps.length){status.textContent='No matching articles. Try another title.';return}status.textContent='Found '+ps.length+' articles. Results are background information, not PPSX33 compatibility ratings.';results.innerHTML=ps.map(p=>'<article class="game-result"><img loading="lazy" src="'+esc(p.thumbnail?.source||'')+'" alt="" onerror="this.style.visibility=\'hidden\'"><div><h3>'+esc(p.title)+'</h3><p>'+esc(p.extract||'Open the article for details.')+'</p><button type="button" data-id="'+Number(p.pageid)+'">Read overview →</button><p><a href="'+esc(p.fullurl||('https://en.wikipedia.org/?curid='+p.pageid))+'" target="_blank" rel="noopener noreferrer">Wikipedia ↗</a></p></div></article>').join('');results.querySelectorAll('[data-id]').forEach(b=>b.addEventListener('click',async()=>{detail.hidden=false;detail.innerHTML='<p>Loading overview…</p>';try{const x=await get({action:'query',pageids:b.dataset.id,prop:'extracts|pageimages|info',exintro:1,explaintext:1,exchars:1800,piprop:'thumbnail',pithumbsize:420,inprop:'url'});const p=Object.values(x.query?.pages||{})[0];detail.innerHTML=(p.thumbnail?.source?'<img loading="lazy" src="'+esc(p.thumbnail.source)+'" alt="">':'')+'<h3>'+esc(p.title)+'</h3><p>'+esc(p.extract||'No overview available.')+'</p><p><a href="'+esc(p.fullurl||('https://en.wikipedia.org/?curid='+p.pageid))+'" target="_blank" rel="noopener noreferrer">Read full Wikipedia article ↗</a></p><small>Wikipedia contributor content; not a PPSX33 compatibility report.</small>';detail.scrollIntoView({behavior:reduce?'auto':'smooth',block:'nearest'})}catch{detail.innerHTML='<p>Could not load the article. Try the Wikipedia link in its result card.</p>'}}))}catch{status.textContent='Wikipedia could not be reached. Check your connection and try again.'}})}
 // Visual archive: load supported image files and matching basename .txt captions.
 const g=document.querySelector('#updates-gallery');
 if(g){
  const st=document.querySelector('#updates-status');
  const esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const captionFor=async(name)=>{
   const stem=name.replace(/\.[^.]+$/,'');
   try{
    const r=await fetch('https://raw.githubusercontent.com/NotY215/PPSX33-Web/main/Updates/'+encodeURIComponent(stem)+'.txt',{cache:'no-cache'});
    if(!r.ok)return 'Development snapshot. See the core repository for implementation status.';
    const caption=(await r.text()).trim();
    return caption||'Development snapshot. See the core repository for implementation status.';
   }catch{return 'Development snapshot. See the core repository for implementation status.'}
  };
  fetch('https://api.github.com/repos/NotY215/PPSX33-Web/contents/Updates')
   .then(r=>{if(!r.ok)throw Error('Could not list Updates folder');return r.json()})
   .then(async files=>{
    const imgs=files.filter(f=>f.type==='file'&&/\.(png|jpe?g|webp|gif)$/i.test(f.name)).sort((a,b)=>a.name.localeCompare(b.name));
    if(!imgs.length){g.innerHTML='<div class="loading-card">No snapshots are published yet.</div>';if(st)st.textContent='No image files were found in the Updates folder.';return}
    const cards=await Promise.all(imgs.map(async f=>{
     const caption=await captionFor(f.name);
     const imageUrl='https://raw.githubusercontent.com/NotY215/PPSX33-Web/main/Updates/'+f.name.split('/').map(encodeURIComponent).join('/');
     return '<article class="update-shot"><a href="'+imageUrl+'" target="_blank" rel="noopener noreferrer"><img loading="lazy" src="'+imageUrl+'" alt="'+esc(f.name)+'"></a><div><b>'+esc(f.name)+'</b><p>'+esc(caption)+'</p></div></article>';
    }));
    g.innerHTML=cards.join('');
    if(st)st.textContent=imgs.length+' snapshot'+(imgs.length===1?'':'s')+' loaded with matching captions where available.';
   })
   .catch(()=>{
    g.innerHTML='<div class="loading-card">Gallery unavailable. Check the Updates folder in the website repository and try again.</div>';
    if(st)st.textContent='Could not load the published snapshots.';
   });
 }
});