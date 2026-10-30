/** Typed source companion for /assets/js/app.js. Keep behavior aligned with the browser entry. */
type WikiPage = { pageid:number; index?:number; title:string; extract?:string; fullurl?:string; thumbnail?:{source:string} };
type WikiResponse = { query?:{ pages?:Record<string,WikiPage> } };
type Params = Record<string,string|number>;
const API = "https://en.wikipedia.org/w/api.php";
const reducedMotion = ():boolean => window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const escapeHTML = (value:unknown):string => String(value ?? "").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c] ?? c));
async function wikiRequest(params:Params):Promise<WikiResponse>{
 const url=new URL(API);Object.entries({...params,origin:"*",format:"json"}).forEach(([k,v])=>url.searchParams.set(k,String(v)));
 const response=await fetch(url,{headers:{Accept:"application/json"}});if(!response.ok)throw new Error("Wikipedia request failed");return response.json() as Promise<WikiResponse>;
}
function setupNavigation():void{
 const toggle=document.querySelector<HTMLButtonElement>(".menu-toggle"),nav=document.querySelector<HTMLElement>(".main-nav");
 if(!toggle||!nav)return;
 const marker=document.createComment("navigation-placeholder");nav.parentNode?.insertBefore(marker,nav);
 let backdrop=document.querySelector<HTMLElement>(".nav-backdrop");if(!backdrop){backdrop=document.createElement("div");backdrop.className="nav-backdrop";backdrop.setAttribute("aria-hidden","true");document.body.append(backdrop)}
 const mobile=():boolean=>matchMedia("(max-width:760px)").matches;
 const close=():void=>{nav.classList.remove("open","mobile-drawer");backdrop?.classList.remove("open");document.body.classList.remove("nav-drawer-open");toggle.setAttribute("aria-expanded","false");toggle.setAttribute("aria-label","Open navigation");if(marker.parentNode)marker.parentNode.insertBefore(nav,marker.nextSibling)};
 toggle.addEventListener("click",()=>{if(toggle.getAttribute("aria-expanded")==="true"){close();return}if(!mobile())return;document.body.append(nav);nav.classList.add("mobile-drawer","open");backdrop?.classList.add("open");document.body.classList.add("nav-drawer-open");toggle.setAttribute("aria-expanded","true");toggle.setAttribute("aria-label","Close navigation")});
 backdrop.addEventListener("click",close);nav.querySelectorAll("a").forEach(a=>a.addEventListener("click",close));
 document.addEventListener("keydown",e=>{if(e.key==="Escape"&&toggle.getAttribute("aria-expanded")==="true"){close();toggle.focus()}});
 window.addEventListener("resize",()=>{if(!mobile()&&toggle.getAttribute("aria-expanded")==="true")close()});
}
function setupReveal():void{
 const items=document.querySelectorAll<HTMLElement>(".reveal");
 if(reducedMotion()||!("IntersectionObserver"in window)){items.forEach(el=>el.classList.add("is-visible"));return}
 const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add("is-visible");observer.unobserve(entry.target)}}),{threshold:.08,rootMargin:"0px 0px -25px 0px"});
 items.forEach((el,i)=>{el.style.transitionDelay=`${(i%4)*55}ms`;observer.observe(el)});
}
async function showGameArticle(pageId:number,target:HTMLElement):Promise<void>{
 target.hidden=false;target.textContent="Loading overview...";
 try{const data=await wikiRequest({action:"query",pageids:pageId,prop:"extracts|pageimages|info",exintro:1,explaintext:1,exchars:1800,piprop:"thumbnail",pithumbsize:420,inprop:"url"});
 const page=Object.values(data.query?.pages??{})[0];if(!page)throw new Error("Article unavailable");
 const image=page.thumbnail?.source?`<img loading="lazy" src="${escapeHTML(page.thumbnail.source)}" alt="">`:"";
 const url=page.fullurl??`https://en.wikipedia.org/?curid=${page.pageid}`;
 target.innerHTML=`${image}<h3>${escapeHTML(page.title)}</h3><p>${escapeHTML(page.extract||"No overview available.")}</p><p><a href="${escapeHTML(url)}" target="_blank" rel="noopener noreferrer">Read full Wikipedia article</a></p><small>Wikipedia contributor content. This is not a PPSX33 compatibility report.</small>`;
 target.scrollIntoView({behavior:reducedMotion()?"auto":"smooth",block:"nearest"});
 }catch{target.textContent="Could not load this article. Try its Wikipedia result link."}
}
function setupGameSearch():void{
 const form=document.querySelector<HTMLFormElement>("#game-search-form"),input=document.querySelector<HTMLInputElement>("#game-search-input"),status=document.querySelector<HTMLElement>("#game-search-status"),results=document.querySelector<HTMLElement>("#game-search-results"),detail=document.querySelector<HTMLElement>("#game-detail");
 if(!form||!input||!status||!results||!detail)return;
 form.addEventListener("submit",async event=>{event.preventDefault();const query=input.value.trim();if(query.length<2)return;status.textContent="Searching Wikipedia...";results.replaceChildren();detail.hidden=true;
 try{const data=await wikiRequest({action:"query",generator:"search",gsrsearch:`${query} (video game OR PlayStation 3)`,gsrnamespace:0,gsrlimit:10,prop:"extracts|pageimages|info",exintro:1,explaintext:1,exchars:420,piprop:"thumbnail",pithumbsize:220,inprop:"url"});
 const pages=Object.values(data.query?.pages??{}).sort((a,b)=>(a.index??0)-(b.index??0));if(!pages.length){status.textContent="No matching articles. Try another title.";return}
 status.textContent=`Found ${pages.length} articles. These are background references, not compatibility ratings.`;
 results.innerHTML=pages.map(p=>`<article class="game-result"><img loading="lazy" src="${escapeHTML(p.thumbnail?.source??"")}" alt="" onerror="this.style.visibility='hidden'"><div><h3>${escapeHTML(p.title)}</h3><p>${escapeHTML(p.extract||"Open the article for details.")}</p><button type="button" data-id="${p.pageid}">Read overview</button><p><a href="${escapeHTML(p.fullurl??`https://en.wikipedia.org/?curid=${p.pageid}`)}" target="_blank" rel="noopener noreferrer">Wikipedia</a></p></div></article>`).join("");
 results.querySelectorAll<HTMLButtonElement>("[data-id]").forEach(button=>button.addEventListener("click",()=>void showGameArticle(Number(button.dataset.id),detail)));
 }catch{status.textContent="Wikipedia could not be reached. Check your connection and try again."}});
}
document.addEventListener("DOMContentLoaded",()=>{setupNavigation();setupReveal();setupGameSearch()});
