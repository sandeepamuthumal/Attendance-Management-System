// star rating
const ratingStars = [...document.getElementsByClassName("rating-star")];
const ratingResult = document.querySelector(".rating-value");
printRatingResult(ratingResult);
function executeRating(stars, result) {
  const starClassActive = "rating-star fa-solid fa-star";
  const starClassUnactive = "rating-star fa-regular fa-star";
  const starsLength = stars.length;
  let i;
  stars.map((star) => {
    star.onclick = () => {
      i = stars.indexOf(star);
      if (star.className.indexOf(starClassUnactive) !== -1) {
        printRatingResult(result, i + 1);
        for (i; i >= 0; --i) stars[i].className = starClassActive;
      } else {
        printRatingResult(result, i);
        for (i; i < starsLength; ++i) stars[i].className = starClassUnactive;
      }
    };
  });
}
function printRatingResult(result, num = 0) {
  result.textContent = `${num}`;
}
executeRating(ratingStars, ratingResult);
// face rating
document.querySelectorAll(".feedback li").forEach((entry) =>
  entry.addEventListener("click", (e) => {
    if (!entry.classList.contains("active")) {
      document.querySelector(".feedback li.active").classList.remove("active");
      entry.classList.add("active");
    }
    e.preventDefault();
  })
);
// number rating
const rating_card = document.querySelector(".rating_card");
const back_card = document.querySelector(".back-card");
const rating_button = document.querySelector(".rating-button");
let rating_container = document.querySelector(".ratings");
let ratings = document.querySelectorAll(".rating");
let button = document.querySelector(".button");
let rating;
rating_container.addEventListener("click", (e) => {
  rating = e.target.dataset.rating;
  console.log(rating);
  resetRating();
  ratings[rating].classList.add("rating-selected");
});
function resetRating() {
  ratings.forEach((rating) => {
    rating.classList.remove("rating-selected");
  });
}
rating_button.addEventListener("click", (e) => {
  if (rating !== undefined) {
    rating_card.classList.add("hidden");
    back_card.classList.remove("hidden");
  }
  const result = document.querySelector(".result");
  result.textContent = `You selected ${rating} out of 5`;
});
// slider rating
window.addEventListener("DOMContentLoaded", () => {
  const fr = new FaceRating("#face-rating");
});
class FaceRating {
  constructor(qs) {
    this.input = document.querySelector(qs);
    this.input?.addEventListener("input", this.update.bind(this));
    this.face = this.input?.previousElementSibling;
    this.update();
  }
  update(e) {
    let value = this.input.defaultValue;
    // when manually set
    if (e) value = e.target?.value;
    // when initiated
    else this.input.value = value;
    const min = this.input.min || 0;
    const max = this.input.max || 100;
    const percentRaw = ((value - min) / (max - min)) * 100;
    const percent = +percentRaw.toFixed(2);
    this.input?.style.setProperty("--percent", `${percent}%`);
    // face and range fill colors
    const maxHue = 120;
    const hueExtend = 30;
    const hue = Math.round((maxHue * percent) / 100);
    let hue2 = hue - hueExtend;
    if (hue2 < 0) hue2 += 360;
    const hues = [hue, hue2];
    hues.forEach((h, i) => {
      this.face?.style.setProperty(`--face-hue${i + 1}`, h);
    });
    this.input?.style.setProperty("--input-hue", hue);
    // emotions
    const duration = 1;
    const delay = (-(duration * 0.99) * percent) / 100;
    const parts = ["right", "left", "mouth-lower", "mouth-upper"];
    parts.forEach((p) => {
      const el = this.face?.querySelector(`[data-${p}]`);
      el?.style.setProperty(`--delay-${p}`, `${delay}s`);
    });
    // aria label
    const faces = [
      "Sad face",
      "Slightly sad face",
      "Straight face",
      "Slightly happy face",
      "Happy face",
    ];
    let faceIndex = Math.floor((faces.length * percent) / 100);
    if (faceIndex === faces.length) --faceIndex;
    this.face?.setAttribute("aria-label", faces[faceIndex]);
  }
}
