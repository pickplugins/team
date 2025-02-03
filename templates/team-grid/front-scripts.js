document.addEventListener("DOMContentLoaded", function () {
	class AccordionBuilder {
		constructor(config) {
			this.id = config.id || "";
			this.lazyLoad = config.lazyLoad || false;
			this.activeIndex = config.activeIndex || [999];
			this.navsIndex = config.navsIndex || [];
			this.headerList = config.headerList || [];
			this.wrapperClass = "tabs";
			this.navsWrapper = "navs-wrapper";
			this.navItem = "nav-item";
			this.panelsWrap = "panels-wrap";
			this.pgTabsPanel = "tabs-panel";
			this.expandCollapseAllHndle = ".expand-collapse-all";
			this.iconInAnimation = config.iconInAnimation || "";
			this.iconOutAnimation = config.iconOutAnimation || "";
			this.iconAnimationDuration = parseInt(config.iconAnimationDuration) || 0;
			this.contentInAnimation = config.contentInAnimation || "";
			this.contentOutAnimation = config.contentOutAnimation || "";
			this.contentAnimationDuration = parseInt(config.contentAnimationDuration) || 0;
			this.urlHash = config.urlHash || false;
			this.keepExpandOther = config.keepExpandOther || false;
			this.clickToScrollTop = config.clickToScrollTop || false;
			this.clickToScrollTopOffset = parseInt(config.clickToScrollTopOffset) || 0;

			this.expandCollapseAllEnable = config.expandCollapseAllEnable || false;
			this.expandCollapseAllDelay = parseInt(config.expandCollapseAllDelay) || 0;

			this.searchEnable = config.searchEnable || false;
			this.autoPlay = config.autoPlay || false;
			this.autoPlayDelay = parseInt(config.autoPlayDelay) || 0;
			this.autoPlayTimeout = parseInt(config.autoPlayTimeout) || 0;

			this.init();
		}
		animate(element, animate_name, duration) {

			element.classList.add("animate__animated", "animate__fast", `animate__${animate_name}`);
			setTimeout(() => {
				element.classList.remove("animate__animated", `animate__${animate_name}`);
			}, duration);
		}
		listenUrlHash() {
			var hash = window.location.hash;
			var hashWrap = document.querySelector('[href="' + hash + '"]');
			if (hashWrap == null) return;
			var header = hashWrap.parentElement;
			var index = header.getAttribute("index")
			this.switch(index)
		}

		activeByIndex(index) {

			if (this.id.length == 0) return;
			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index");
				this.activeIndex = index
				var content = header.nextElementSibling;
				if (loopIndex == index) {
					header.classList.toggle("accordion-header-active");
					content.style.display = "block";
					content.style.height = "auto";

					var iconToggle = header.querySelector(".accordion-icon-toggle");
					var iconIdle = header.querySelector(".accordion-icon-idle");
					if (header.classList.contains("accordion-header-active")) {
						if (iconToggle != null) {
							iconToggle.style.display = "inline-block"; this.animate(iconToggle, this.iconInAnimation, this.iconAnimationDuration)
						}
						if (iconIdle != null) {
							iconIdle.style.display = "none";

							this.animate(iconIdle, this.iconOutAnimation, this.iconAnimationDuration)

						}
						content.style.display = "block";
						content.style.height = "auto";

						this.animate(content, this.contentInAnimation, this.contentAnimationDuration)

					} else {
						if (iconIdle != null) {
							iconIdle.style.display = "inline-block";
						}
						if (iconToggle != null) {
							iconToggle.style.display = "none";
						}

						this.animate(content, this.contentOutAnimation, this.contentAnimationDuration)

					}
				}
			});
		}
		inactiveByIndex(index) {
			if (this.id.length == 0) return;
			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index"); var content = header.nextElementSibling;
				if (loopIndex == index) {
					header.classList.toggle("accordion-header-active");
					//content.style.display = "none";
					//content.style.height = 0;
				}

				var iconToggle = header.querySelector(".accordion-icon-toggle");
				var iconIdle = header.querySelector(".accordion-icon-idle"); if (header.classList.contains("accordion-header-active")) {
					if (iconToggle != null) {
						iconToggle.style.display = "inline-block";

						this.animate(iconToggle, this.iconInAnimation, this.iconAnimationDuration)

					}
					if (iconIdle != null) {
						iconIdle.style.display = "none";

						this.animate(iconIdle, this.iconOutAnimation, this.iconAnimationDuration)
					}
					content.style.display = "block";
					content.style.height = "auto";

					this.animate(content, this.contentInAnimation, this.contentAnimationDuration)

				} else {
					if (iconIdle != null) {
						iconIdle.style.display = "inline-block";
					}
					if (iconToggle != null) {
						iconToggle.style.display = "none";
					}
					content.style.display = "none";

					this.animate(content, this.contentOutAnimation, this.contentAnimationDuration)
				}
			});
		}
		hideByIndex(index) {
			if (this.id.length == 0) return;
			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index");

				if (index == loopIndex) {
					var content = header.nextElementSibling;
					//content.style.display = "none";
					header.style.display = "none";
				}
			});
		}
		unhideByIndex(index) {
			if (this.id.length == 0) return;
			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index");

				if (index == loopIndex) {
					var content = header.nextElementSibling;
					//content.style.display = "block";
					header.style.display = "flex";
				}
			});
		}
		unhideAll(index) {
			if (this.id.length == 0) return;
			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index"); var content = header.nextElementSibling;
				content.style.display = "none";
				header.style.display = "flex";

			});
		}

		switch(index) {


			if (this.id.length == 0) return;
			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index");
				this.activeIndex = index
				var content = header.nextElementSibling;
				if (loopIndex == index) {
					header.classList.toggle("accordion-header-active");
					content.style.display = "block";
					content.style.height = "auto";
				} else {
					header.classList.remove("accordion-header-active");
					content.style.display = "none";
					content.style.height = 0;
				}
				var iconToggle = header.querySelector(".accordion-icon-toggle");
				var iconIdle = header.querySelector(".accordion-icon-idle");
				if (header.classList.contains("accordion-header-active")) {
					if (iconToggle != null) {
						iconToggle.style.display = "inline-block";
						this.animate(iconToggle, this.iconInAnimation, this.iconAnimationDuration)
					}
					if (iconIdle != null) {
						iconIdle.style.display = "none";
						this.animate(iconIdle, this.iconOutAnimation, this.iconAnimationDuration)
					}

					content.style.display = "block";
					content.style.height = "auto";

					this.animate(content, this.contentInAnimation, this.contentAnimationDuration)
				} else {
					if (iconIdle != null) {
						iconIdle.style.display = "inline-block";
					}
					if (iconToggle != null) {
						iconToggle.style.display = "none";
					} this.animate(content, this.contentOutAnimation, this.contentAnimationDuration)
					content.style.display = "none";
				}
			});
		}
		switchNext() {
			var activeIndex = this.activeIndex;
			var max = this.headerList.length - 1;
			var nextIndex = (activeIndex + 1 > max) ? 0 : (activeIndex + 1);
			this.switch(nextIndex);
		}
		switchPrev() {
			var activeIndex = this.activeIndex;
			var max = this.headerList.length - 1;
			var nextIndex = (activeIndex - 1 < 0) ? max : (activeIndex - 1);
			this.switch(nextIndex);
		}

		autoPlayRun() {
			let currentIndex = -1;
			const loopThroughItems = () => {

				var length = this.headerList.length + 1;

				currentIndex = (currentIndex + 1) % length;

				this.switch(currentIndex);
				setTimeout(loopThroughItems, this.autoPlayDelay);
			};

			if (this.autoPlay) loopThroughItems();
		}

		search(keyword) {

			if (keyword.length == 0) {
				this.unhideAll()

				return;

			}

			var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");
			accordionHeaders.forEach((header, i) => {
				var loopIndex = header.getAttribute("index");

				//this.activeIndex = index
				var content = header.nextElementSibling;

				var headerLabel = header.querySelector(".accordion-header-label");

				var labelText = headerLabel.innerText.toLowerCase();;
				var contentText = content.innerText.toLowerCase();;

				var searchContent = labelText + " " + contentText
				var position = searchContent.indexOf(keyword);
				if (position < 0) {
					this.hideByIndex(loopIndex)

				} else {
					this.unhideByIndex(loopIndex)
				}

			});
		}
		expandCollapseAll() {
			var expandCollapseAllHndle = document.querySelector("#" + this.id + " " + this.expandCollapseAllHndle);

			var toggled = expandCollapseAllHndle.getAttribute("data-toggled");
			var headerCount = this.headerList.length
			var expandCollapseAllDelay = parseInt(this.expandCollapseAllDelay);
			var expandalltext = expandCollapseAllHndle.getAttribute("data-expandalltext");
			var collapsealltext = expandCollapseAllHndle.getAttribute("data-collapsealltext");
			var expandalliconhtml = expandCollapseAllHndle.getAttribute("data-expandalliconhtml");
			var collapsealliconhtml = expandCollapseAllHndle.getAttribute("data-collapsealliconhtml");

			if (!toggled) {
				expandCollapseAllHndle.setAttribute("data-toggled", true);
				var innerHtml = `${collapsealliconhtml}<span>${collapsealltext}</span>`;

				var _this = this;

				for (var i = 0; i < headerCount; i++) {
					(function (index) {
						setTimeout(function () {
							_this.activeByIndex(index)
						}, expandCollapseAllDelay * index);
					})(i);

				}

			} else {

				var _this = this;
				for (var i = 0; i < headerCount; i++) {

					(function (index) {
						setTimeout(function () {
							_this.inactiveByIndex(index)
						}, expandCollapseAllDelay * index);
					})(i);

				}
				expandCollapseAllHndle.removeAttribute("data-toggled");
				var innerHtml = `${expandalliconhtml}<span>${expandalltext}</span>`;

			}

			expandCollapseAllHndle.innerHTML = innerHtml

		}
		init() {
			const accordionWrapper = document.querySelector(`#${this.id}`);
			if (this.lazyLoad) accordionWrapper.style.display = "block"; var accordionHeaders = document.querySelectorAll("#" + this.id + " > .accordion-header");

			var headerList = [];
			accordionHeaders.forEach((header, index) => {
				var headerId = header.getAttribute("id");
				headerList.push(headerId)
				header.setAttribute("index", index);
				const counter = header.querySelector(".accordion-label-counter");
				if (counter !== null) {
					counter.textContent = `${index + 1}`; // Adding 1 to start counting from 1
				}
			});
			this.headerList = headerList;
			accordionHeaders.forEach((accordionHeader) => {
				var iconToggle = accordionHeader.querySelector(".accordion-icon-toggle");
				var iconIdle = accordionHeader.querySelector(".accordion-icon");
				if (iconToggle != null) {
					iconToggle.style.display = "none";
				}
			});
			if (accordionHeaders != null) {
				accordionHeaders.forEach((accordionHeader) => {
					// var fieldId = accordionHeader.getAttribute("id");
					var content = accordionHeader.nextElementSibling;
					var iconToggle = accordionHeader.querySelector(".accordion-icon-toggle");
					var iconIdle = accordionHeader.querySelector(".accordion-icon-idle");
					if (iconToggle != null) {
						iconToggle.style.display = "none";
					}
					if (content != undefined) {
						content.style.height = 0;
						content.style.overflow = "hidden";
						content.style.display = "none";
					}
					accordionHeader.addEventListener("click", (event) => {

						event.stopImmediatePropagation();
						event.preventDefault();						//accordionHeader.scrollIntoView({ behavior: 'smooth' });

						if (this.clickToScrollTop) {
							var offset = this.clickToScrollTopOffset;

							const elementPosition = accordionHeader.getBoundingClientRect().top + window.scrollY;
							const offsetPosition = elementPosition - offset;

							window.scrollTo({
								top: offsetPosition,
								behavior: 'smooth'
							});

						}

						var loopIndex = accordionHeader.getAttribute("index");

						if (this.keepExpandOther) {
							this.activeByIndex(loopIndex);
						} else {

							this.switch(loopIndex);
						}
					});
				});
			}

			if (this.activeIndex.length > 1) {
				this.activeIndex.map((index) => {
					this.activeByIndex(index);
				})

			}

			if (this.urlHash) this.listenUrlHash();
			if (this.autoPlay) this.autoPlayRun();
			if (this.expandCollapseAllEnable) {
				var expandCollapseAllHndle = document.querySelector("#" + this.id + " " + this.expandCollapseAllHndle);

				if (expandCollapseAllHndle != null) {
					var _this = this;
					expandCollapseAllHndle.addEventListener("click", function (event) {

						_this.expandCollapseAll();
					})
				}

			}
			if (this.searchEnable) {

				var _this = this;

				var searchHndle = document.querySelector("#" + this.id + " .search-input");

				if (searchHndle != null) {
					function debounce(func, delay) {
						let timeout;
						return function (...args) {
							clearTimeout(timeout);
							timeout = setTimeout(() => func.apply(this, args), delay);
						};
					} function handleKeyup(event) {
						event.preventDefault();

						var value = event.target.value;
						_this.search(value)
					}

					searchHndle.addEventListener('keyup', debounce(handleKeyup, 500));

				}
			}
		}
	}

	// Initialize instances
	document.querySelectorAll("[data-accordionBuilder]").forEach((tabElement) => {

		const config = JSON.parse(tabElement.getAttribute("data-accordionBuilder"));

		new AccordionBuilder(config);
	});
});
