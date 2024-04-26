<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src=""></script>
    <script src=""></script>
</head>
<style>

.wrapper {
  max-width: 1100px;
  width: 100%;
  position: relative;
}
.wrapper i {
  top: 50%;
  height: 50px;
  width: 50px;
  cursor: pointer;
  font-size: 1.25rem;
  position: absolute;
  text-align: center;
  line-height: 50px;
  background: #fff;
  border-radius: 50%;
  box-shadow: 0 3px 6px rgba(0,0,0,0.23);
  transform: translateY(-50%);
  transition: transform 0.1s linear;
}


#left{
  left: -22px;
} 

#right{
  right: -22px;
}

.wrapper .carousel{
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: calc((100% / 3) - 12px);
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  gap: 16px;
  border-radius: 8px;
  scroll-behavior: smooth;
  scrollbar-width: none;
}
/* .carousel::-webkit-scrollbar {
  display: none;
} */
.carousel .card, .carousel .img {
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel .card {
  scroll-snap-align: start;
  height: 342px;
  list-style: none;
  background: #fff;
  cursor: pointer;
  padding-bottom: 15px;
  flex-direction: column;
  border-radius: 8px;
}

.carousel .img {
  background-color: #ffed4c;
  height: 110px;
  width: 110px;
  border-radius: 50%;
}
.card .img img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #fff;
}

.carousel .card h2 {
  font-weight: 500;
  font-size: 1.56rem;
  margin: 30px 0 5px;
}
.carousel .card span {
  color: #7895ff;
  font-size: 1.31rem;
}

.wrapper i:active{
  transform: translateY(-50%) scale(0.85);
}



</style>
<body>

<div class="wrapper">
      <i id="left" class="fa-solid fa-angle-left"></i>
      <ul class="carousel">
        <li class="card">
          <div class="img"><img src="https://picsum.photos/200" alt="img" draggable="false"></div>
          <h2>Blanche Pearson</h2>
          <span>Sales Manager</span>
        </li>
        <li class="card">
          <div class="img"><img src="https://picsum.photos/200" alt="img" draggable="false"></div>
          <h2>Joenas Brauers</h2>
          <span>Web Developer</span>
        </li>
        <li class="card">
          <div class="img"><img src="https://picsum.photos/200" alt="img" draggable="false"></div>
          <h2>Lariach French</h2>
          <span>Online Teacher</span>
        </li>
        <li class="card">
          <div class="img"><img src="https://picsum.photos/200" alt="img" draggable="false"></div>
          <h2>James Khosravi</h2>
          <span>Freelancer</span>
        </li>
        <li class="card">
          <div class="img"><img src="https://picsum.photos/200" alt="img" draggable="false"></div>
          <h2>Kristina Zasiadko</h2>
          <span>Bank Manager</span>
        </li>
        <li class="card">
          <div class="img"><img src="https://picsum.photos/200" alt="img" draggable="false"></div>
          <h2>Donald Horton</h2>
          <span>App Designer</span>
        </li>
      </ul>
      <i id="right" class="fa-solid fa-angle-right"></i>
    </div>

    <script>

document.addEventListener('DOMContentLoaded', function () {
    const leftArrow = document.getElementById('left');
    const rightArrow = document.getElementById('right');
    const carousel = document.querySelector('.carousel');
    
    rightArrow.addEventListener('click', function () {
        carousel.scrollBy({
            left: 250,
            behavior: 'smooth'
        });
    });
    
    leftArrow.addEventListener('click', function () {
        carousel.scrollBy({
            left: -250,
            behavior: 'smooth'
        });
    });
    
});

    </script>
</body>

</html>
