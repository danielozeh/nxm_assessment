var app = new Vue({
  el: "#sell",

  data: function() {
    return {
      prices: [
        {
          price: 0,

          quantity: 1,

          rate: 0,

          variation_id: 0
        }
      ],

      hidePrices: false,

      showSpinner: false,

      currency: "",

      card_acceptance_form: "",

      faceValues: [],

      faceValue: Object,

      existsAlready: false,

      showTotalPrice: false,

      totalPrice: 0,

      totalQuantity: 0,

      data: [],

      images: [],

      added: []

      // cardsWithReceipts: 0,

      // showReceiptsForm: false
    };
  },

  mounted() {
    this.init();
  },

  methods: {
    init() {},

    Check: function(data) {
      this.calculateTotalPrice();

      if (this.added.includes(data.value)) {
        toastr.warning("Ooops! You chose this face value already");

        // let element = this.$refs.pop();

        let element = this.$refs.facevalue.pop();

        // console.log(element.keys);

        return;
      } else {
        this.added.push(data.value);
      }
    },

    acceptanceChanges: function() {
      if (this.currency && this.card_acceptance_form) {
        this.added = [];

        var mydropzone = new Dropzone("#my-dropzone");

        mydropzone.on("addedfile", function(file) {
          files = mydropzone.files;
          if (files.length) {
            let i, len;
            for (
              i = 0, len = files.length;
              i < len - 1;
              i++ // -1 to exclude current file
            ) {
              if (
                files[i].name === file.name &&
                files[i].size === file.size &&
                this.files[i].lastModifiedDate.toString() ===
                  file.lastModifiedDate.toString()
              ) {
                toastr.warning("This Card has already been added");
                this.removeFile(file);
              }
            }
          }
        });
        mydropzone.on("maxfilesexceeded", function(file) {
          toastr.warning(
            "Ooops! You cant add more than 10 files per transaction"
          );
          this.removeFile(file);
        });
        this.showSpinner = !this.showSpinner;

        data = {
          currency: this.currency,

          card_acceptance_form: this.card_acceptance_form,

          card_uuid: document.getElementById("card_uuid").value
        };

        try {
          axios.post("/sell/face-value", data).then(response => {
            data = response.data.response.data;

            this.showSpinner = true;

            faceValues = [];

            if (data.length > 0) {
              result = [];

              data.forEach(function(item) {
                faceValues = {
                  value: item.face_value,

                  rate: item.rate,

                  variation_id: item.variation_id
                  // 'has_receipt': item.has_receipt
                };

                result.push(faceValues);
              });

              // I am getting an Object from the API so i needed to convert it

              // to an Array of Objects where each object contains Values, Rate and VariationId

              // send the result to the Face Value

              this.faceValues = result;

              this.hidePrices = true;
            } else {
              toastr.warning("Cards for the chosen set are not available");

              this.card_acceptance_form = "";

              this.currency = "";

              this.hidePrices = false;
              this.showSpinner = false;
            }
            this.showSpinner = !this.showSpinner;
          });
        } catch (error) {
          toastr.error(
            "Ooops! Check your Internet Settings, Could not fetch Data"
          );
          this.showSpinner = false;
        }
      }
    },

    addPrice: function() {
      this.prices.push({
        price: "",

        quantity: "",

        rate: 0
      });
    },

    deletePrice: function(index) {
      if (index == 0) {
        toastr.error("Cannot Delete the First Price");

        return;
      }

      prices = this.prices[index];

      price = prices.price.value;

      let singleindex = this.added.indexOf(price);

      if (singleindex !== -1) this.added.splice(singleindex, 1);

      this.prices.splice(index, 1);
    },

    showTotal() {
      this.calculateTotalPrice();

      this.showTotalPrice = !this.showTotalPrice;
    },

    calculateTotalPrice() {
      let sum = 0;

      let data = [];

      let totalQuantity = 0;

      // let cardsWithReceipts = 0;

      this.prices.forEach(function(item) {
        if (item.price.rate == undefined) {
          toastr.warning("Ooops! No Value was set for one of your card rates");

          return;
        }

        sum += item.price.rate * item.quantity;

        totalQuantity += Number(item.quantity);

        // if (item.price.has_receipt == true) cardsWithReceipts += Number(item.quantity);

        // Get the Variation and Quantity

        data.push({
          quantity: item.quantity,

          variation_id: item.price.variation_id
        });
      });

      this.totalPrice = sum;

      this.totalQuantity = totalQuantity;

      this.data = data;

      // this.cardsWithReceipts = cardsWithReceipts;
    },

    openModal() {
      this.calculateTotalPrice();

      total = this.totalQuantity;

      if (total > 10) {
        toastr.warning(
          "Ooops! You cant send beyond 10 cards for each transaction"
        );

        return;
      }

      $("#upload-image").modal("show");
    },

    proceed: function() {
      this.calculateTotalPrice();

      var mydropzone = new Dropzone("#my-dropzone");
      let images = mydropzone.files;
      let total = this.totalQuantity;
      // let cardsWithReceipts = this.cardsWithReceipts;
      let dbData;
      let receipts;

      //   if (total > 10) {
      //     toastr.warning(
      //       "Ooops! You cant send beyond 10 cards for each transaction"
      //     );
      //     return;
      //   }

      if (total == 0 || this.data.length < 1 || this.totalPrice == 0) {
        toastr.warning("Ooops! You have not selected any cards yet");
        return;
      }

      // if (cardsWithReceipts > 0) {
      //     if (!this.showReceiptsForm) {
      //         toastr.warning("Kindly add Receipts to continue");
      //         return;
      //     }
      //     var receiptDropzone = new Dropzone("#receipt-dropzone");
      //     receipts = receiptDropzone.files;

      //     if (receipts.length != cardsWithReceipts) {
      //         toastr.warning("Add Just " + this.cardsWithReceipts + " receipts to proceed")
      //         return;
      //     }

      // }

      if (this.card_acceptance_form == "picture") {
        // if (total < images.length) {
        //   toastr.warning(
        //     "Ooops! You are selling " +
        //       total +
        //       " cards" +
        //       " and you uploaded " +
        //       images.length +
        //       " cards,  Kindly reduce the cards"
        //   );
        //   return;
        // }
        // if (total > images.length) {
        //   toastr.warning(
        //     "Ooops! You are selling " +
        //       total +
        //       " cards" +
        //       " and you uploaded " +
        //       images.length +
        //       " cards, Kindly add more cards"
        //   );
        //   return;
        // }
      } else {
        if (images.length > 1) {
          toastr.error(
            "Oooops! You cant upload more than one card for an e-code transaction"
          );
          return;
        }
      }

      swal({
        title: "Are you sure you want to sell this Card??",
        text: "After submitting, you cannot undo this process!",
        icon: "warning",
        buttons: true,
        dangerMode: true
      }).then(sendCard => {
        if (sendCard) {
          dbData = {
            data: this.data,
            images: images,
            receipts: receipts
          };
          $("#proceed-loader").show();

          $("#btn-text").text("Processing");

          $("#proceedButton").attr("disabled", "disabled");

          this.uploadCardToSever(dbData);
        } else {
          swal("Click the Proceed Button to process your transaction");
        }
      });
    },

    // openReceiptForm() {
    //     this.showReceiptsForm = !this.showReceiptsForm;
    //     let cardsWithReceipts = this.cardsWithReceipts
    //     setTimeout(() => {
    //         var receiptDropzone = new Dropzone("#receipt-dropzone", {
    //             dictDefaultMessage: "Add " + cardsWithReceipts + " receipts",
    //             maxFiles: cardsWithReceipts,
    //             dictMaxFilesExceeded: "You can only add " + cardsWithReceipts + " receipts",
    //         });
    //         receiptDropzone.on("maxfilesexceeded", function (file) {
    //             toastr.warning("Ooops! You cant add more than " + cardsWithReceipts + " receipts")
    //             this.removeFile(file);
    //         });
    //     })
    // },
    uploadCardToSever(data) {
      try {
        axios
          .post("/sale", data)
          .then(response => {
            response = response.data.response;

            $("#proceedButton").removeAttr("disabled", "disabled");

            $("#btn-text")
              .fadeIn(100)
              .text("Proceed");
            $("#proceed-loader").fadeOut(50);

            if (response.error) {
              toastr.error(response.message);
            } else {
              $("#upload-image").modal("hide");

              var mydropzone = new Dropzone("#my-dropzone");

              mydropzone.removeAllFiles();

              toastr.success(
                "Your Cards have been submitted! KIndly stay back for five minutes"
              );

              this.prices = [];

              this.currency = "";

              this.card_acceptance_form = "";

              this.card_acceptance_form = "";

              setTimeout(() => (location.href = "../dashboard"), 2000);
            }
          })
          .catch(error => {
            $("#proceedButton").removeAttr("disabled", "disabled");
            $("#btn-text")
              .fadeIn(100)
              .text("Proceed");
            $("#proceed-loader").fadeOut(50);

            toastr.error("It appears an error has occured, please try again");
          });
      } catch (e) {
        toastr.error("Oooops! Bad Network Connection");
      }
    }
  }
});
