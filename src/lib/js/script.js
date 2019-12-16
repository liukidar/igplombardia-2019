export function listFiles(ctx) {
  return ctx.keys().map((el) => { return el.substr(2) })
}

export function scrollTo(id) {
  setTimeout(function() {
		if (id) {
			let offset = document.getElementById(id).getBoundingClientRect().top
			let navbar = document.getElementsByClassName('navbar-fixed')
			if (navbar.length) offset -= navbar[0].clientHeight
			window.scrollBy({ top: offset, behavior: 'smooth' })
		}
		else {
			window.scrollBy({ top: -window.pageYOffset, behavior: 'smooth' })
		}
  }, 0)
}