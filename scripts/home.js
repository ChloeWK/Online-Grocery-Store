// 首页轮播图功能
document.addEventListener("DOMContentLoaded", () => {
  // 轮播图元素
  const slides = document.querySelectorAll(".hero-slide")
  const dots = document.querySelectorAll(".slider-dot")
  const prevBtn = document.querySelector(".slider-prev")
  const nextBtn = document.querySelector(".slider-next")

  // 如果页面上没有轮播图元素，则退出
  if (!slides.length || !dots.length) return

  let currentSlide = 0
  let slideInterval

  // 显示指定索引的幻灯片
  function showSlide(index) {
    // 确保索引在有效范围内
    if (index < 0) index = slides.length - 1
    if (index >= slides.length) index = 0

    // 隐藏所有幻灯片
    slides.forEach((slide) => {
      slide.classList.remove("active")
    })

    // 移除所有点的活动状态
    dots.forEach((dot) => {
      dot.classList.remove("active")
    })

    // 显示当前幻灯片和点
    slides[index].classList.add("active")
    dots[index].classList.add("active")
    currentSlide = index
  }

  // 显示下一张幻灯片
  function nextSlide() {
    showSlide(currentSlide + 1)
  }

  // 显示上一张幻灯片
  function prevSlide() {
    showSlide(currentSlide - 1)
  }

  // 开始自动轮播
  function startSlideshow() {
    // 清除任何现有的定时器
    if (slideInterval) {
      clearInterval(slideInterval)
    }

    // 设置新的定时器，每5秒切换一次
    slideInterval = setInterval(nextSlide, 5000)
  }

  // 停止自动轮播
  function stopSlideshow() {
    clearInterval(slideInterval)
  }

  // 点击下一张按钮
  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      nextSlide()
      // 点击后重新开始自动轮播
      stopSlideshow()
      startSlideshow()
    })
  }

  // 点击上一张按钮
  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      prevSlide()
      // 点击后重新开始自动轮播
      stopSlideshow()
      startSlideshow()
    })
  }

  // 点击导航点
  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      showSlide(index)
      // 点击后重新开始自动轮播
      stopSlideshow()
      startSlideshow()
    })
  })

  // 鼠标悬停在轮播图上时暂停自动轮播
  const heroSection = document.querySelector(".hero-banner")
  if (heroSection) {
    heroSection.addEventListener("mouseenter", stopSlideshow)
    heroSection.addEventListener("mouseleave", startSlideshow)
  }

  // 开始自动轮播
  startSlideshow()
})

// 添加左右箭头图标
document.addEventListener("DOMContentLoaded", () => {
  // 创建左右箭头SVG图标
  const createChevronIcon = (direction) => {
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg")
    svg.setAttribute("width", "24")
    svg.setAttribute("height", "24")
    svg.setAttribute("viewBox", "0 0 24 24")
    svg.setAttribute("fill", "none")
    svg.setAttribute("stroke", "currentColor")
    svg.setAttribute("stroke-width", "2")
    svg.setAttribute("stroke-linecap", "round")
    svg.setAttribute("stroke-linejoin", "round")

    const path = document.createElementNS("http://www.w3.org/2000/svg", "polyline")
    if (direction === "left") {
      path.setAttribute("points", "15 18 9 12 15 6")
    } else {
      path.setAttribute("points", "9 18 15 12 9 6")
    }

    svg.appendChild(path)
    return svg
  }

  // 添加左右箭头图标
  const prevBtn = document.querySelector(".slider-prev")
  const nextBtn = document.querySelector(".slider-next")

  if (prevBtn && !prevBtn.querySelector("svg")) {
    prevBtn.innerHTML = ""
    prevBtn.appendChild(createChevronIcon("left"))
  }

  if (nextBtn && !nextBtn.querySelector("svg")) {
    nextBtn.innerHTML = ""
    nextBtn.appendChild(createChevronIcon("right"))
  }
})

// 产品滑动功能
document.addEventListener("DOMContentLoaded", () => {
  const productRow = document.getElementById("featured-products-row")
  const nextBtn = document.getElementById("featured-next")
  const prevBtn = document.getElementById("featured-prev")

  if (!productRow || !nextBtn || !prevBtn) return

  // 设置每次滚动的距离（约等于一个产品卡片的宽度加上间距）
  const scrollAmount = 300
  let currentScroll = 0

  // 点击下一个按钮滚动
  nextBtn.addEventListener("click", () => {
    currentScroll += scrollAmount
    productRow.scrollTo({
      left: currentScroll,
      behavior: "smooth",
    })

    // 滚动后检查是否需要显示或隐藏箭头
    checkArrows()
  })

  // 点击上一个按钮滚动
  prevBtn.addEventListener("click", () => {
    currentScroll -= scrollAmount
    if (currentScroll < 0) currentScroll = 0

    productRow.scrollTo({
      left: currentScroll,
      behavior: "smooth",
    })

    // 滚动后检查是否需要显示或隐藏箭头
    checkArrows()
  })

  // 监听���动事件
  productRow.addEventListener("scroll", () => {
    // 更新当前滚动位置
    currentScroll = productRow.scrollLeft

    // 检查是否需要显示或隐藏箭头
    checkArrows()
  })

  // 检查是否需要显示或隐藏箭头
  function checkArrows() {
    const maxScroll = productRow.scrollWidth - productRow.clientWidth

    // 如果已经滚动，显示左箭头否则隐藏
    if (currentScroll > 0) {
      prevBtn.style.display = "flex"
    } else {
      prevBtn.style.display = "none"
    }

    // 如果还可以继续滚动，显示右箭头，否则隐藏
    if (currentScroll >= maxScroll - 10) {
      nextBtn.style.display = "none"
    } else {
      nextBtn.style.display = "flex"
    }
  }

  // 初始检查箭头状态
  checkArrows()

  // 窗口大小改变时重新检查箭头状态
  window.addEventListener("resize", checkArrows)
})

// Special Offers Slider
document.addEventListener("DOMContentLoaded", () => {
  // 获取所有幻灯片和导航点
  const offerSlides = document.querySelectorAll(".offers-slide")
  const offerDots = document.querySelectorAll(".offer-dot")

  if (!offerSlides.length || !offerDots.length) return

  // 设置当前幻灯片索引
  let currentOfferSlide = 0

  // 显示指定索引的幻灯片
  function showOfferSlide(index) {
    // 隐藏所有幻灯片
    offerSlides.forEach((slide) => {
      slide.classList.remove("active")
    })

    // 移除所有导航点的活动状态
    offerDots.forEach((dot) => {
      dot.classList.remove("active")
    })

    // 显示当前幻灯片和激活对应的导航点
    offerSlides[index].classList.add("active")
    offerDots[index].classList.add("active")

    // 更新当前索引
    currentOfferSlide = index
  }

  // 为每个导航点添加点击事件
  offerDots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      showOfferSlide(index)
    })
  })

  // 自动播放幻灯片（可选）
  let offerSlideInterval

  function startOfferSlideShow() {
    offerSlideInterval = setInterval(() => {
      const nextSlide = (currentOfferSlide + 1) % offerSlides.length
      showOfferSlide(nextSlide)
    }, 5000) // 每5秒切换一次
  }

  // 当用户与幻灯片交互时暂停自动播放
  function pauseOfferSlideShow() {
    clearInterval(offerSlideInterval)
  }

  // 当用户离开幻灯片区域时恢复自动播放
  function resumeOfferSlideShow() {
    pauseOfferSlideShow()
    startOfferSlideShow()
  }

  // 为幻灯片区域添加鼠标事件
  const offersContainer = document.querySelector(".offers-banner")
  if (offersContainer) {
    offersContainer.addEventListener("mouseenter", pauseOfferSlideShow)
    offersContainer.addEventListener("mouseleave", resumeOfferSlideShow)
  }

  // 开始自动播放
  startOfferSlideShow()
})

// New Arrivals 滑动功能
document.addEventListener("DOMContentLoaded", () => {
  const newProductsGrid = document.querySelector(".new-products-grid")
  const prevBtn = document.getElementById("new-prev")
  const nextBtn = document.getElementById("new-next")

  if (!newProductsGrid || !prevBtn || !nextBtn) return

  // 在小屏幕上显示箭头
  function checkScreenSize() {
    if (window.innerWidth <= 1200) {
      prevBtn.style.display = "flex"
      nextBtn.style.display = "flex"
    } else {
      prevBtn.style.display = "none"
      nextBtn.style.display = "none"
    }
  }

  // 初始检查
  checkScreenSize()

  // 窗口大小改变时重新检查
  window.addEventListener("resize", checkScreenSize)

  // 设置滑动距离
  const scrollAmount = 300

  // 点击下一个按钮滚动
  nextBtn.addEventListener("click", () => {
    newProductsGrid.scrollBy({
      left: scrollAmount,
      behavior: "smooth",
    })
  })

  // 点击上一个按钮滚动
  prevBtn.addEventListener("click", () => {
    newProductsGrid.scrollBy({
      left: -scrollAmount,
      behavior: "smooth",
    })
  })

  // 监听滚动事件，控制箭头显示
  newProductsGrid.addEventListener("scroll", () => {
    if (newProductsGrid.scrollLeft <= 10) {
      prevBtn.style.opacity = "0.5"
    } else {
      prevBtn.style.opacity = "1"
    }

    if (newProductsGrid.scrollLeft >= newProductsGrid.scrollWidth - newProductsGrid.clientWidth - 10) {
      nextBtn.style.opacity = "0.5"
    } else {
      nextBtn.style.opacity = "1"
    }
  })
})

// 在文件末尾添加以下代码，确保产品卡片点击事件在所有页面加载后正确绑定

// 确保产品卡片点击事件正确绑定
document.addEventListener("DOMContentLoaded", () => {
  // 为所有产品卡片添加点击事件
  const productCards = document.querySelectorAll(".product-card, .new-product-card")

  productCards.forEach((card) => {
    if (card.hasAttribute("onclick")) {
      // 如果已经有onclick属性，确保它能正常工作
      const onclickValue = card.getAttribute("onclick")
      card.addEventListener("click", () => {
        eval(onclickValue)
      })
    }
  })

  // 阻止Add to Cart按钮的事件冒泡
  const addToCartButtons = document.querySelectorAll(".add-to-cart, .add-to-cart-btn")
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.stopPropagation()
    })
  })
})
