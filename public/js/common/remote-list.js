/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/components/remote-list.js":
/*!************************************************!*\
  !*** ./resources/js/components/remote-list.js ***!
  \************************************************/
/***/ (() => {

eval("var spinner = $('#remote-modal__spinner');\n$('.remote-modal__show').on('click', function (el) {\n  var deleteId = $(el.target).data('remote-id');\n  $('#remote-modal__delete').attr('data-remote-id', deleteId);\n});\n$('#remote-modal__delete').on('click', function () {\n  $('#remote-modal__delete').hide();\n  spinner.show();\n  var deleteId = $('#remote-modal__delete').data('remote-id');\n  $.ajax({\n    method: 'DELETE',\n    url: \"/remote/\".concat(deleteId),\n    data: {\n      \"_token\": $('meta[name=\"csrf-token\"]').attr('content')\n    },\n    success: function success(Response) {\n      window.location.href = '/remote';\n    },\n    error: function error(Error) {\n      window.location.href = '/remote';\n    },\n    always: function always() {\n      spinner.hide();\n      $('#remote-modal__delete').show();\n    }\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY29tcG9uZW50cy9yZW1vdGUtbGlzdC5qcz80NGE3Il0sIm5hbWVzIjpbInNwaW5uZXIiLCIkIiwib24iLCJlbCIsImRlbGV0ZUlkIiwidGFyZ2V0IiwiZGF0YSIsImF0dHIiLCJoaWRlIiwic2hvdyIsImFqYXgiLCJtZXRob2QiLCJ1cmwiLCJzdWNjZXNzIiwiUmVzcG9uc2UiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsImhyZWYiLCJlcnJvciIsIkVycm9yIiwiYWx3YXlzIl0sIm1hcHBpbmdzIjoiQUFBQSxJQUFNQSxPQUFPLEdBQUdDLENBQUMsQ0FBQyx3QkFBRCxDQUFqQjtBQUVJQSxDQUFDLENBQUMscUJBQUQsQ0FBRCxDQUF5QkMsRUFBekIsQ0FBNEIsT0FBNUIsRUFBcUMsVUFBQ0MsRUFBRCxFQUFRO0FBQ3pDLE1BQU1DLFFBQVEsR0FBR0gsQ0FBQyxDQUFDRSxFQUFFLENBQUNFLE1BQUosQ0FBRCxDQUFhQyxJQUFiLENBQWtCLFdBQWxCLENBQWpCO0FBQ0FMLEVBQUFBLENBQUMsQ0FBQyx1QkFBRCxDQUFELENBQTJCTSxJQUEzQixDQUFnQyxnQkFBaEMsRUFBa0RILFFBQWxEO0FBQ0gsQ0FIRDtBQUtBSCxDQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQkMsRUFBM0IsQ0FBOEIsT0FBOUIsRUFBdUMsWUFBTTtBQUN6Q0QsRUFBQUEsQ0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJPLElBQTNCO0FBQ0FSLEVBQUFBLE9BQU8sQ0FBQ1MsSUFBUjtBQUNBLE1BQU1MLFFBQVEsR0FBR0gsQ0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJLLElBQTNCLENBQWdDLFdBQWhDLENBQWpCO0FBQ0FMLEVBQUFBLENBQUMsQ0FBQ1MsSUFBRixDQUFPO0FBQ0hDLElBQUFBLE1BQU0sRUFBRSxRQURMO0FBRUhDLElBQUFBLEdBQUcsb0JBQWFSLFFBQWIsQ0FGQTtBQUdIRSxJQUFBQSxJQUFJLEVBQUU7QUFBQyxnQkFBVUwsQ0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJNLElBQTdCLENBQWtDLFNBQWxDO0FBQVgsS0FISDtBQUlITSxJQUFBQSxPQUpHLG1CQUlLQyxRQUpMLEVBSWU7QUFDZEMsTUFBQUEsTUFBTSxDQUFDQyxRQUFQLENBQWdCQyxJQUFoQixHQUF1QixTQUF2QjtBQUNILEtBTkU7QUFPSEMsSUFBQUEsS0FQRyxpQkFPR0MsS0FQSCxFQU9VO0FBQ1RKLE1BQUFBLE1BQU0sQ0FBQ0MsUUFBUCxDQUFnQkMsSUFBaEIsR0FBdUIsU0FBdkI7QUFDSCxLQVRFO0FBVUhHLElBQUFBLE1BVkcsb0JBVU07QUFDTHBCLE1BQUFBLE9BQU8sQ0FBQ1EsSUFBUjtBQUNBUCxNQUFBQSxDQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQlEsSUFBM0I7QUFDSDtBQWJFLEdBQVA7QUFlSCxDQW5CRCIsInNvdXJjZXNDb250ZW50IjpbImNvbnN0IHNwaW5uZXIgPSAkKCcjcmVtb3RlLW1vZGFsX19zcGlubmVyJyk7XHJcblxyXG4gICAgJCgnLnJlbW90ZS1tb2RhbF9fc2hvdycpLm9uKCdjbGljaycsIChlbCkgPT4ge1xyXG4gICAgICAgIGNvbnN0IGRlbGV0ZUlkID0gJChlbC50YXJnZXQpLmRhdGEoJ3JlbW90ZS1pZCcpO1xyXG4gICAgICAgICQoJyNyZW1vdGUtbW9kYWxfX2RlbGV0ZScpLmF0dHIoJ2RhdGEtcmVtb3RlLWlkJywgZGVsZXRlSWQpO1xyXG4gICAgfSk7XHJcblxyXG4gICAgJCgnI3JlbW90ZS1tb2RhbF9fZGVsZXRlJykub24oJ2NsaWNrJywgKCkgPT4ge1xyXG4gICAgICAgICQoJyNyZW1vdGUtbW9kYWxfX2RlbGV0ZScpLmhpZGUoKTtcclxuICAgICAgICBzcGlubmVyLnNob3coKTtcclxuICAgICAgICBjb25zdCBkZWxldGVJZCA9ICQoJyNyZW1vdGUtbW9kYWxfX2RlbGV0ZScpLmRhdGEoJ3JlbW90ZS1pZCcpO1xyXG4gICAgICAgICQuYWpheCh7XHJcbiAgICAgICAgICAgIG1ldGhvZDogJ0RFTEVURScsXHJcbiAgICAgICAgICAgIHVybDogYC9yZW1vdGUvJHtkZWxldGVJZH1gLFxyXG4gICAgICAgICAgICBkYXRhOiB7XCJfdG9rZW5cIjogJCgnbWV0YVtuYW1lPVwiY3NyZi10b2tlblwiXScpLmF0dHIoJ2NvbnRlbnQnKX0sXHJcbiAgICAgICAgICAgIHN1Y2Nlc3MoUmVzcG9uc2UpIHtcclxuICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gJy9yZW1vdGUnO1xyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBlcnJvcihFcnJvcikge1xyXG4gICAgICAgICAgICAgICAgd2luZG93LmxvY2F0aW9uLmhyZWYgPSAnL3JlbW90ZSc7XHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIGFsd2F5cygpIHtcclxuICAgICAgICAgICAgICAgIHNwaW5uZXIuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgJCgnI3JlbW90ZS1tb2RhbF9fZGVsZXRlJykuc2hvdygpO1xyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgIH0pXHJcbiAgICB9KTtcclxuXHJcbiJdLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvY29tcG9uZW50cy9yZW1vdGUtbGlzdC5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/components/remote-list.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/components/remote-list.js"]();
/******/ 	
/******/ })()
;