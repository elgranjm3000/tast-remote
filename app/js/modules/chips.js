const chips = () => {
	/**************************
 * Auto complete plugin  *
 *************************/
	$.fn.autocomplete = function(options) {
		// Defaults
		var defaults = {
			data: {},
			limit: Infinity,
			onAutocomplete: null,
			minLength: 1
		};

		options = $.extend(defaults, options);

		return this.each(function() {
			var $input = $(this);
			var data = options.data,
				count = 0,
				activeIndex = -1,
				oldVal,
				$inputDiv = $input.closest(".input-field"); // Div to append on

			// Check if data isn't empty
			if (!$.isEmptyObject(data)) {
				var $autocomplete = $(
					'<ul class="autocomplete-content dropdown-content"></ul>'
				);
				var $oldAutocomplete;

				// Append autocomplete element.
				// Prevent double structure init.
				if ($inputDiv.length) {
					$oldAutocomplete = $inputDiv
						.children(".autocomplete-content.dropdown-content")
						.first();
					if (!$oldAutocomplete.length) {
						$inputDiv.append($autocomplete); // Set ul in body
					}
				} else {
					$oldAutocomplete = $input.next(
						".autocomplete-content.dropdown-content"
					);
					if (!$oldAutocomplete.length) {
						$input.after($autocomplete);
					}
				}
				if ($oldAutocomplete.length) {
					$autocomplete = $oldAutocomplete;
				}

				// Highlight partial match.
				var highlight = function(string, $el) {
					var img = $el.find("img");
					var matchStart = $el
						.text()
						.toLowerCase()
						.indexOf("" + string.toLowerCase() + ""),
						matchEnd = matchStart + string.length - 1,
						beforeMatch = $el.text().slice(0, matchStart),
						matchText = $el.text().slice(matchStart, matchEnd + 1),
						afterMatch = $el.text().slice(matchEnd + 1);
					$el.html(
						"<span>" +
							beforeMatch +
							"<span class='highlight'>" +
							matchText +
							"</span>" +
							afterMatch +
							"</span>"
					);
					if (img.length) {
						$el.prepend(img);
					}
				};

				// Reset current element position
				var resetCurrentElement = function() {
					activeIndex = -1;
					$autocomplete.find(".active").removeClass("active");
				};

				// Remove autocomplete elements
				var removeAutocomplete = function() {
					$autocomplete.empty();
					resetCurrentElement();
					oldVal = undefined;
				};

				$input.off("blur.autocomplete").on("blur.autocomplete", function() {
					removeAutocomplete();
				});

				// Perform search
				$input
					.off("keyup.autocomplete focus.autocomplete")
					.on("keyup.autocomplete focus.autocomplete", function(e) {
						// Reset count.
						count = 0;
						var val = $input.val().toLowerCase();

						// Don't capture enter or arrow key usage.
						if (e.which === 13 || e.which === 38 || e.which === 40) {
							return;
						}

						// Check if the input isn't empty
						if (oldVal !== val) {
							removeAutocomplete();

							if (val.length >= options.minLength) {
								for (var key in data) {
									if (
										data.hasOwnProperty(key) &&
										key.toLowerCase().indexOf(val) !== -1 &&
										key.toLowerCase() !== val
									) {
										// Break if past limit
										if (count >= options.limit) {
											break;
										}

										var autocompleteOption = $("<li></li>");
										if (!!data[key]) {
											autocompleteOption.append(
												'<img src="' +
													data[key] +
													'" class="right circle"><span>' +
													key +
													"</span>"
											);
										} else {
											autocompleteOption.append("<span>" + key + "</span>");
										}

										$autocomplete.append(autocompleteOption);
										highlight(val, autocompleteOption);
										count++;
									}
								}
							}
						}

						// Update oldVal
						oldVal = val;
					});

				$input
					.off("keydown.autocomplete")
					.on("keydown.autocomplete", function(e) {
						// Arrow keys and enter key usage
						var keyCode = e.which,
							liElement,
							numItems = $autocomplete.children("li").length,
							$active = $autocomplete.children(".active").first();

						// select element on Enter
						if (keyCode === 13 && activeIndex >= 0) {
							liElement = $autocomplete.children("li").eq(activeIndex);
							if (liElement.length) {
								liElement.trigger("mousedown.autocomplete");
								e.preventDefault();
							}
							return;
						}

						// Capture up and down key
						if (keyCode === 38 || keyCode === 40) {
							e.preventDefault();

							if (keyCode === 38 && activeIndex > 0) {
								activeIndex--;
							}

							if (keyCode === 40 && activeIndex < numItems - 1) {
								activeIndex++;
							}

							$active.removeClass("active");
							if (activeIndex >= 0) {
								$autocomplete.children("li").eq(activeIndex).addClass("active");
							}
						}
					});

				// Set input value
				$autocomplete.on(
					"mousedown.autocomplete touchstart.autocomplete",
					"li",
					function() {
						var text = $(this).text().trim();
						$input.val(text);
						$input.trigger("change");
						removeAutocomplete();

						// Handle onAutocomplete callback.
						if (typeof options.onAutocomplete === "function") {
							options.onAutocomplete.call(this, text);
						}
					}
				);
			}
		});
	};

	var materialChipsDefaults = {
		data: [],
		placeholder: "",
		secondaryPlaceholder: "",
		autocompleteOptions: {}
	};

	$(document).ready(function() {
		// Handle removal of static chips.
		$(document).on("click", ".chip .close", function(e) {
			var $chips = $(this).closest(".chips");
			if ($chips.attr("data-initialized")) {
				return;
			}
			$(this).closest(".chip").remove();
		});
	});

	$.fn.material_chip = function(options) {
		var self = this;
		this.$el = $(this);
		this.$document = $(document);
		this.SELS = {
			CHIPS: ".chips",
			CHIP: ".chip",
			INPUT: "input",
			DELETE: ".zmdi.zmdi-close",
			SELECTED_CHIP: ".selected"
		};

		if ("data" === options) {
			return this.$el.data("chips");
		}

		var curr_options = $.extend({}, materialChipsDefaults, options);
		self.hasAutocomplete = !$.isEmptyObject(
			curr_options.autocompleteOptions.data
		);

		// Initialize
		this.init = function() {
			var i = 0;
			var chips;
			self.$el.each(function() {
				var $chips = $(this);
				var chipId = Materialize.guid();
				self.chipId = chipId;

				if (!curr_options.data || !(curr_options.data instanceof Array)) {
					curr_options.data = [];
				}
				$chips.data("chips", curr_options.data);
				$chips.attr("data-index", i);
				$chips.attr("data-initialized", true);

				if (!$chips.hasClass(self.SELS.CHIPS)) {
					$chips.addClass("chips");
				}

				self.chips($chips, chipId);
				i++;
			});
		};

		this.handleEvents = function() {
			var SELS = self.SELS;

			self.$document
				.off("click.chips-focus", SELS.CHIPS)
				.on("click.chips-focus", SELS.CHIPS, function(e) {
					$(e.target).find(SELS.INPUT).focus();
				});

			self.$document
				.off("click.chips-select", SELS.CHIP)
				.on("click.chips-select", SELS.CHIP, function(e) {
					var $chip = $(e.target);
					if ($chip.length) {
						var wasSelected = $chip.hasClass("selected");
						var $chips = $chip.closest(SELS.CHIPS);
						$(SELS.CHIP).removeClass("selected");

						if (!wasSelected) {
							self.selectChip($chip.index(), $chips);
						}
					}
				});

			self.$document.off("keydown.chips").on("keydown.chips", function(e) {
				if ($(e.target).is("input, textarea")) {
					return;
				}

				// delete
				var $chip = self.$document.find(SELS.CHIP + SELS.SELECTED_CHIP);
				var $chips = $chip.closest(SELS.CHIPS);
				var length = $chip.siblings(SELS.CHIP).length;
				var index;

				if (!$chip.length) {
					return;
				}

				if (e.which === 8 || e.which === 46) {
					e.preventDefault();

					index = $chip.index();
					self.deleteChip(index, $chips);

					var selectIndex = null;
					if (index + 1 < length) {
						selectIndex = index;
					} else if (index === length || index + 1 === length) {
						selectIndex = length - 1;
					}

					if (selectIndex < 0) selectIndex = null;

					if (null !== selectIndex) {
						self.selectChip(selectIndex, $chips);
					}
					if (!length) $chips.find("input").focus();

					// left
				} else if (e.which === 37) {
					index = $chip.index() - 1;
					if (index < 0) {
						return;
					}
					$(SELS.CHIP).removeClass("selected");
					self.selectChip(index, $chips);

					// right
				} else if (e.which === 39) {
					index = $chip.index() + 1;
					$(SELS.CHIP).removeClass("selected");
					if (index > length) {
						$chips.find("input").focus();
						return;
					}
					self.selectChip(index, $chips);
				}
			});

			self.$document
				.off("focusin.chips", SELS.CHIPS + " " + SELS.INPUT)
				.on("focusin.chips", SELS.CHIPS + " " + SELS.INPUT, function(e) {
					var $currChips = $(e.target).closest(SELS.CHIPS);
					$currChips.addClass("focus");
					$currChips.siblings("label, .prefix").addClass("active");
					$(SELS.CHIP).removeClass("selected");
				});

			self.$document
				.off("focusout.chips", SELS.CHIPS + " " + SELS.INPUT)
				.on("focusout.chips", SELS.CHIPS + " " + SELS.INPUT, function(e) {
					var $currChips = $(e.target).closest(SELS.CHIPS);
					$currChips.removeClass("focus");

					// Remove active if empty
					if (
						$currChips.data("chips") === undefined ||
						!$currChips.data("chips").length
					) {
						$currChips.siblings("label").removeClass("active");
					}
					$currChips.siblings(".prefix").removeClass("active");
				});

			self.$document
				.off("keydown.chips-add", SELS.CHIPS + " " + SELS.INPUT)
				.on("keydown.chips-add", SELS.CHIPS + " " + SELS.INPUT, function(e) {
					var $target = $(e.target);
					var $chips = $target.closest(SELS.CHIPS);
					var chipsLength = $chips.children(SELS.CHIP).length;

					// enter
					if (13 === e.which) {
						// Override enter if autocompleting.
						if (
							self.hasAutocomplete &&
							$chips.find(".autocomplete-content.dropdown-content").length &&
							$chips.find(".autocomplete-content.dropdown-content").children()
								.length
						) {
							return;
						}

						e.preventDefault();
						self.addChip({ tag: $target.val() }, $chips);
						$target.val("");
						return;
					}

					// delete or left
					if (
						(8 === e.keyCode || 37 === e.keyCode) &&
						"" === $target.val() &&
						chipsLength
					) {
						e.preventDefault();
						self.selectChip(chipsLength - 1, $chips);
						$target.blur();
						return;
					}
				});

			// Click on delete icon in chip.
			self.$document
				.off("click.chips-delete", SELS.CHIPS + " " + SELS.DELETE)
				.on("click.chips-delete", SELS.CHIPS + " " + SELS.DELETE, function(e) {
					var $target = $(e.target);
					var $chips = $target.closest(SELS.CHIPS);
					var $chip = $target.closest(SELS.CHIP);
					e.stopPropagation();
					self.deleteChip($chip.index(), $chips);
					$chips.find("input").focus();
				});
		};

		this.chips = function($chips, chipId) {
			$chips.empty();
			$chips.data("chips").forEach(function(elem) {
				$chips.append(self.renderChip(elem));
			});
			$chips.append(
				$('<input id="' + chipId + '" class="input" placeholder="">')
			);
			self.setPlaceholder($chips);

			// Set for attribute for label
			var label = $chips.next("label");
			if (label.length) {
				label.attr("for", chipId);

				if ($chips.data("chips") !== undefined && $chips.data("chips").length) {
					label.addClass("active");
				}
			}

			// Setup autocomplete if needed.
			var input = $("#" + chipId);
			if (self.hasAutocomplete) {
				curr_options.autocompleteOptions.onAutocomplete = function(val) {
					self.addChip({ tag: val }, $chips);
					input.val("");
					input.focus();
				};
				input.autocomplete(curr_options.autocompleteOptions);
			}
		};

		/**
	     * Render chip jQuery element.
	     * @param {Object} elem
	     * @return {jQuery}
	     */
		this.renderChip = function(elem) {
			if (!elem.tag) return;

			var $renderedChip = $('<div class="chip"></div>');
			$renderedChip.text(elem.tag);
			if (elem.image) {
				$renderedChip.prepend($("<img />").attr("src", elem.image));
			}
			$renderedChip.append($('<i class="material-icons close">close</i>'));
			return $renderedChip;
		};

		this.setPlaceholder = function($chips) {
			if (
				$chips.data("chips") !== undefined &&
				$chips.data("chips").length &&
				curr_options.placeholder
			) {
				$chips.find("input").prop("placeholder", curr_options.placeholder);
			} else if (
				($chips.data("chips") === undefined || !$chips.data("chips").length) &&
				curr_options.secondaryPlaceholder
			) {
				$chips
					.find("input")
					.prop("placeholder", curr_options.secondaryPlaceholder);
			}
		};

		this.isValid = function($chips, elem) {
			var chips = $chips.data("chips");
			var exists = false;
			for (var i = 0; i < chips.length; i++) {
				if (chips[i].tag === elem.tag) {
					exists = true;
					return;
				}
			}
			return "" !== elem.tag && !exists;
		};

		this.addChip = function(elem, $chips) {
			if (!self.isValid($chips, elem)) {
				return;
			}
			var $renderedChip = self.renderChip(elem);
			var newData = [];
			var oldData = $chips.data("chips");
			for (var i = 0; i < oldData.length; i++) {
				newData.push(oldData[i]);
			}
			newData.push(elem);

			$chips.data("chips", newData);
			$renderedChip.insertBefore($chips.find("input"));
			$chips.trigger("chip.add", elem);
			self.setPlaceholder($chips);
		};

		this.deleteChip = function(chipIndex, $chips) {
			var chip = $chips.data("chips")[chipIndex];
			$chips.find(".chip").eq(chipIndex).remove();

			var newData = [];
			var oldData = $chips.data("chips");
			for (var i = 0; i < oldData.length; i++) {
				if (i !== chipIndex) {
					newData.push(oldData[i]);
				}
			}

			$chips.data("chips", newData);
			$chips.trigger("chip.delete", chip);
			self.setPlaceholder($chips);
		};

		this.selectChip = function(chipIndex, $chips) {
			var $chip = $chips.find(".chip").eq(chipIndex);
			if ($chip && false === $chip.hasClass("selected")) {
				$chip.addClass("selected");
				$chips.trigger("chip.select", $chips.data("chips")[chipIndex]);
			}
		};

		this.getChipsElement = function(index, $chips) {
			return $chips.eq(index);
		};

		// init
		this.init();

		this.handleEvents();
	};
};
const initChips = () => {
	//jQuery Initialization for autocomplete chips
	$(".chips-autocomplete").material_chip({
		autocompleteOptions: {
			data: {
				Alabama: null,
				Alaska: null,
				Arizona: null,
				Arkansas: null
			},
			limit: Infinity,
			minLength: 1
		}
	});
	//-END jQuery Initialization for autocomplete chips
};
export { chips, initChips };
