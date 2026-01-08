// 获取基础URL
const baseUrl = document.querySelector('meta[name="base-url"]')?.getAttribute("content") || "/"

// 全局变量和函数
const isCartInitialized = false

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM加载完成，初始化购物车功能")

  // 处理导航菜单的交互
  setupNavigation()

  // 处理newsletter表单提交
  setupNewsletterForm()
})

// 设置导航菜单交互
function setupNavigation() {
  console.log("设置导航菜单交互")

  const dropdowns = document.querySelectorAll(".has-dropdown")

  dropdowns.forEach((dropdown) => {
    // 鼠标进入下拉菜单项时显示下拉菜单
    dropdown.addEventListener("mouseenter", function () {
      const dropdownMenu = this.querySelector(".dropdown-menu")
      if (dropdownMenu) {
        dropdownMenu.style.opacity = "1"
        dropdownMenu.style.visibility = "visible"
      }
    })

    // 鼠标离开下拉菜单项时隐藏下拉菜单
    dropdown.addEventListener("mouseleave", function () {
      const dropdownMenu = this.querySelector(".dropdown-menu")
      if (dropdownMenu) {
        dropdownMenu.style.opacity = "0"
        dropdownMenu.style.visibility = "hidden"
      }
    })
  })

  // 移动端菜单切换
  const menuToggle = document.createElement("button")
  menuToggle.className = "menu-toggle"
  menuToggle.innerHTML = "<span></span><span></span><span></span>"
  menuToggle.setAttribute("aria-label", "Toggle menu")

  const mainNav = document.querySelector(".main-nav")
  if (mainNav) {
    const navContainer = mainNav.querySelector(".nav-container")
    if (navContainer && !navContainer.querySelector(".menu-toggle")) {
      navContainer.insertBefore(menuToggle, navContainer.firstChild)

      menuToggle.addEventListener("click", function () {
        mainNav.classList.toggle("active")

        // 更新aria-expanded属性
        const isExpanded = mainNav.classList.contains("active")
        this.setAttribute("aria-expanded", isExpanded)
      })
    }
  }
}

// 设置Newsletter表单提交
function setupNewsletterForm() {
  console.log("设置Newsletter表单提交")

  const newsletterForm = document.querySelector(".newsletter-form")
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", function (e) {
      e.preventDefault()

      const emailInput = this.querySelector('input[type="email"]')
      if (!emailInput) {
        console.warn("未找到email输入框")
        return
      }

      const email = emailInput.value.trim()

      if (email) {
        console.log("提交newsletter订阅:", email)

        // 临时显示成功消息
        showNotification(`Thank you for subscribing with ${email}!`)
        emailInput.value = ""
      }
    })
  }
}

// 添加到购物车功能 - 全局函数
window.addToCart = (productId, productName, price, quantity = 1, originalPrice = null, image = null) => {
  console.log("添加商品到购物车:", {
    productId,
    productName,
    price,
    quantity,
    originalPrice,
    image,
  })

  // 获取现有购物车数据
  const cartItems = localStorage.getItem("cartItems") ? JSON.parse(localStorage.getItem("cartItems")) : []

  // 检查产品是否已在购物车中
  const existingItemIndex = cartItems.findIndex((item) => item.id === productId)

  if (existingItemIndex > -1) {
    // 更新数量
    cartItems[existingItemIndex].quantity += quantity
    console.log("更新现有商品数量")
  } else {
    // 添加新商品
    cartItems.push({
      id: productId,
      name: productName,
      price: Number.parseFloat(price),
      originalPrice: originalPrice ? Number.parseFloat(originalPrice) : null,
      quantity: quantity,
      image: image,
    })
    console.log("添加新商品到购物车")
  }

  // 保存到localStorage
  localStorage.setItem("cartItems", JSON.stringify(cartItems))

  // 触发自定义事件，通知header更新购物车
  document.dispatchEvent(new CustomEvent("cartUpdated"))

  // 显示添加成功消息
  showNotification(`${productName} added to cart!`)
}

// 显示通知 - 全局函数
window.showNotification = (message) => {
  console.log("显示通知:", message)

  // 检查是否已存在通知元素
  let notification = document.querySelector(".cart-notification")

  // 如果不存在，创建一个
  if (!notification) {
    notification = document.createElement("div")
    notification.className = "cart-notification"
    document.body.appendChild(notification)
  }

  // 设置消息内容
  notification.textContent = message

  // 显示通知
  setTimeout(() => {
    notification.style.opacity = "1"
    notification.style.transform = "translateY(0)"
  }, 10)

  // 3秒后隐藏通知
  setTimeout(() => {
    notification.style.opacity = "0"
    notification.style.transform = "translateY(20px)"

    // 动画完成后移除元素
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification)
      }
    }, 300)
  }, 3000)
}

// 页面加载时清除localStorage中的登录状态
document.addEventListener("DOMContentLoaded", () => {
  // 清除localStorage中的登录状态
  localStorage.removeItem("userLoggedIn")
  localStorage.removeItem("username")
  localStorage.removeItem("userId")
  localStorage.removeItem("userEmail")
  console.log("已清除localStorage中的登录状态")
})
