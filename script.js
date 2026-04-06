const msg = document.getElementById("msg");
const popup = document.getElementById("popup");
const popupText = document.getElementById("popup-text");
const closePopup = document.getElementById("closePopup");
const form = document.getElementById("reservationForm");

const params = new URLSearchParams(window.location.search);
const status = params.get("status");

if (status === "succes") {
  if (msg) {
    msg.innerText = "Rezervarea a fost trimisă cu succes!";
    msg.style.color = "green";
    msg.style.fontWeight = "bold";
    msg.style.marginTop = "12px";
  }

  if (popup && popupText) {
    popupText.innerText = "Rezervarea a fost trimisă cu succes!";
    popup.classList.add("show");
  }

  if (form) {
    form.reset();
  }
}

if (status === "telefon") {
  if (msg) {
    msg.innerText = "Numărul de telefon nu este valid.";
    msg.style.color = "red";
    msg.style.fontWeight = "bold";
    msg.style.marginTop = "12px";
  }
}

if (status === "gol") {
  if (msg) {
    msg.innerText = "Completează toate câmpurile.";
    msg.style.color = "red";
    msg.style.fontWeight = "bold";
    msg.style.marginTop = "12px";
  }
}

if (status === "eroare") {
  if (msg) {
    msg.innerText = "A apărut o eroare la trimitere.";
    msg.style.color = "red";
    msg.style.fontWeight = "bold";
    msg.style.marginTop = "12px";
  }
}

if (closePopup && popup) {
  closePopup.addEventListener("click", () => {
    popup.classList.remove("show");
  });
}

if (popup) {
  popup.addEventListener("click", (e) => {
    if (e.target === popup) {
      popup.classList.remove("show");
    }
  });
}

const foodImages = (window.foodImages && window.foodImages.length > 0) ? window.foodImages : [];

if (foodImages.length === 0) {
  console.warn('Nu sunt imagini pentru slider. Asigură-te că `menu.php` setează window.foodImages corect.');
} else {
  console.log('Folosește aceste imagini în slider:', foodImages);
}


let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const track = document.getElementById('slidesTrack');
const nextBtn = document.getElementById('nextSlide');
const prevBtn = document.getElementById('prevSlide');
const visibleCount = 2;
let slideInterval;

function updateTrack() {
  if (!track || !slides.length) return;
  const availableSlides = Array.from(slides).filter(slide => !slide.classList.contains('slide-error'));
  if (!availableSlides.length) {
    track.style.transform = 'translateX(0)';
    return;
  }

  const totalSlides = availableSlides.length;
  slideIndex = slideIndex % totalSlides;
  if (slideIndex < 0) slideIndex += totalSlides;

  const translate = -(slideIndex * (100 / visibleCount));
  track.style.transform = `translateX(${translate}%)`;

  slides.forEach((slide, idx) => {
    const visible = availableSlides.slice(slideIndex, slideIndex + visibleCount).includes(slide);
    slide.classList.toggle('active', visible);
  });
}

function nextSlide() {
  slideIndex = (slideIndex + visibleCount) % slides.length;
  updateTrack();
}

function prevSlide() {
  slideIndex = (slideIndex - visibleCount + slides.length) % slides.length;
  updateTrack();
}

function startAutoSlide() {
  stopAutoSlide();
  slideInterval = setInterval(nextSlide, 4500);
}

function stopAutoSlide() {
  if (slideInterval) {
    clearInterval(slideInterval);
    slideInterval = null;
  }
}

if (slides.length > 0) {
  updateTrack();
  startAutoSlide();
}

if (nextBtn) {
  nextBtn.addEventListener('click', () => {
    stopAutoSlide();
    nextSlide();
    startAutoSlide();
  });
}

if (prevBtn) {
  prevBtn.addEventListener('click', () => {
    stopAutoSlide();
    prevSlide();
    startAutoSlide();
  });
}

const foodSliderElement = document.getElementById('foodSlider');
if (foodSliderElement) {
  foodSliderElement.addEventListener('mouseenter', stopAutoSlide);
  foodSliderElement.addEventListener('mouseleave', startAutoSlide);
}


const menuModal = document.getElementById("menuModal");
const modalClose = document.getElementById("modalClose");
const modalImage = document.getElementById("modalImage");
const modalTitle = document.getElementById("modalTitle");
const modalShort = document.getElementById("modalShort");
const modalDescription = document.getElementById("modalDescription");
const modalAllergens = document.getElementById("modalAllergens");
const modalPrice = document.getElementById("modalPrice");
const qtyMinus = document.getElementById("qtyMinus");
const qtyPlus = document.getElementById("qtyPlus");
const qtyInput = document.getElementById("qtyInput");
const addToCartBtn = document.getElementById("addToCartBtn");
const cartStatus = document.getElementById("cartStatus");
const toast = document.getElementById("toast");

let currentPrice = 0;

function setToast(message){
  if(!toast) return;
  toast.textContent = message;
  toast.classList.add('show');
  setTimeout(()=>toast.classList.remove('show'), 2000);
}

function getCart(){
  try {
    const raw = localStorage.getItem('igusto_cart');
    return raw ? JSON.parse(raw) : [];
  } catch(e) {
    console.error('Eroare parsare coș:', e);
    return [];
  }
}

function saveCart(cart){
  localStorage.setItem('igusto_cart', JSON.stringify(cart));
  updateCartCount();
}

function updateCartCount(){
  const cartCountEl = document.getElementById('cartCount');
  if(!cartCountEl) return;
  const cart = getCart();
  const totalQty = cart.reduce((s,item)=>s + Number(item.qty || 0), 0);
  cartCountEl.textContent = totalQty;
}

function addToCart(item){
  const cart = getCart();

  const key = item.title;
  const existing = cart.find(i=>i.key===key);

  if(existing){
    existing.qty = Number(existing.qty) + Number(item.qty);
    existing.total = existing.qty * existing.price;
  } else {
    cart.push({
      key,
      title: item.title,
      qty: Number(item.qty),
      price: Number(item.price),
      total: Number(item.qty)*Number(item.price),
      image: item.image,
      allergens: item.allergens
    });
  }

  saveCart(cart);
  setToast(`${item.qty} x ${item.title} adăugat în coș`);
}

function formatLei(val){
  return Number(val).toFixed(2).replace('.00','') + ' lei';
}

function renderCartPage(){
  const cartPage = document.getElementById('cartPage');
  if(!cartPage) return;

  const cart = getCart();
  const cartContent = document.getElementById('cartContent');
  if(!cartContent) return;

  if(cart.length===0){
    cartContent.innerHTML = '<div class="cart-empty">Coșul este gol.</div>';
    return;
  }

  const rows = cart.map((item, idx)=>{
    return `
      <tr>
        <td>${item.title}</td>
        <td>
          <button class="cart-qty-btn" data-action="dec" data-idx="${idx}">-</button>
          ${item.qty}
          <button class="cart-qty-btn" data-action="inc" data-idx="${idx}">+</button>
        </td>
        <td>${formatLei(item.price)}</td>
        <td>${formatLei(item.total)}</td>
        <td><button class="cart-remove" data-idx="${idx}">Şterge</button></td>
      </tr>`;
  }).join('');

  const subtotal = cart.reduce((sum,item)=>sum + Number(item.total), 0);

  cartContent.innerHTML = `
    <table class="cart-table">
      <thead><tr><th>Produs</th><th>Cant.</th><th>Preț/u</th><th>Total</th><th>Acțiune</th></tr></thead>
      <tbody>${rows}</tbody>
    </table>
    <div class="cart-summary">Total coș: <strong>${formatLei(subtotal)}</strong></div>
    <div style="margin-top:12px; text-align:right;"><button id="clearCart" class="cart-clear">Golește coș</button></div>
  `;

  cartContent.querySelectorAll('.cart-remove').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const idx = Number(btn.dataset.idx);
      cart.splice(idx,1);
      saveCart(cart);
      renderCartPage();
    });
  });

  cartContent.querySelectorAll('.cart-qty-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const idx = Number(btn.dataset.idx);
      if(btn.dataset.action==='inc') cart[idx].qty = Number(cart[idx].qty)+1;
      if(btn.dataset.action==='dec' && Number(cart[idx].qty) > 1) cart[idx].qty = Number(cart[idx].qty)-1;
      cart[idx].total = cart[idx].qty * cart[idx].price;
      saveCart(cart);
      renderCartPage();
    });
  });

  const clearBtn = document.getElementById('clearCart');
  if(clearBtn){
    clearBtn.addEventListener('click', ()=>{
      if(confirm('Golești coșul?')){
        saveCart([]);
        renderCartPage();
      }
    });
  }
}

window.addEventListener('DOMContentLoaded', ()=>{
  updateCartCount();
  renderCartPage();
});

function openModal(item){
  modalImage.src = item.dataset.image;
  modalImage.onerror = function(){
    this.onerror = null;
    this.src = 'https://via.placeholder.com/480x480?text=Imagine+inexistentă';
  };
  modalTitle.textContent = item.dataset.title;
  modalShort.textContent = item.dataset.short;
  modalDescription.textContent = item.dataset.desc;
  modalAllergens.textContent = 'Alergeni: ' + item.dataset.allergens;
  currentPrice = Number(item.dataset.price);
  modalPrice.textContent = currentPrice + ' lei';
  qtyInput.value = 1;

  cartStatus.textContent = '';
  menuModal.classList.add('show');
}

function closeModal(){
  menuModal.classList.remove('show');
}

document.querySelectorAll('.menu-card').forEach(card => {
  card.addEventListener('click', () => openModal(card));
});

if(modalClose) modalClose.addEventListener('click', closeModal);
if(menuModal) menuModal.addEventListener('click', (e)=>{ if(e.target===menuModal) closeModal(); });

if(qtyMinus) qtyMinus.addEventListener('click', ()=>{
  let val = Number(qtyInput.value);
  if(val>1){ qtyInput.value = val-1; }
});
if(qtyPlus) qtyPlus.addEventListener('click', ()=>{
  let val = Number(qtyInput.value);
  qtyInput.value = val+1;
});

if(addToCartBtn){
  addToCartBtn.addEventListener('click', ()=>{
    const qty = Math.max(1, Number(qtyInput.value));
    const item = {
      title: modalTitle.textContent,
      qty,
      price: currentPrice,
      image: modalImage.src,
      allergens: modalAllergens.textContent.replace('Alergeni: ', '')
    };

    addToCart(item);
    cartStatus.textContent = `Adăugat ${qty} x ${item.title} în coș.`;
  });
}


const dataInput = document.getElementById("data");
if (dataInput) {
  const today = new Date().toISOString().split("T")[0];
  dataInput.min = today;
}

const oraInput = document.getElementById("ora");
if (oraInput) {
  oraInput.addEventListener("change", function () {
    const ora = this.value;

    if (ora < "10:00" || ora > "22:00") {
      alert("Programul este între 10:00 și 22:00");
      this.value = "";
    }
  });
}

