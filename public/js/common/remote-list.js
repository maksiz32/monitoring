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

eval("var spinner = $('#remote-modal__spinner');\n$('.remote-modal__show').on('click', function (el) {\n  var deleteId = $(el.target).data('remote-id');\n  $('#remote-modal__delete').attr('data-remote-id', deleteId);\n});\n$('#remote-modal__delete').on('click', function () {\n  $('#remote-modal__delete').hide();\n  spinner.show();\n  var deleteId = $('#remote-modal__delete').data('remote-id');\n  $.ajax({\n    method: 'DELETE',\n    url: \"/remote/\".concat(deleteId),\n    data: {\n      \"_token\": $('meta[name=\"csrf-token\"]').attr('content')\n    },\n    success: function success(Response) {\n      window.location.href = '/remote';\n    },\n    error: function error(Error) {\n      window.location.href = '/remote';\n    },\n    always: function always() {\n      spinner.hide();\n      $('#remote-modal__delete').show();\n    }\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY29tcG9uZW50cy9yZW1vdGUtbGlzdC5qcz80NGE3Il0sIm5hbWVzIjpbInNwaW5uZXIiLCIkIiwib24iLCJlbCIsImRlbGV0ZUlkIiwidGFyZ2V0IiwiZGF0YSIsImF0dHIiLCJoaWRlIiwic2hvdyIsImFqYXgiLCJtZXRob2QiLCJ1cmwiLCJzdWNjZXNzIiwiUmVzcG9uc2UiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsImhyZWYiLCJlcnJvciIsIkVycm9yIiwiYWx3YXlzIl0sIm1hcHBpbmdzIjoiQUFBQSxJQUFNQSxPQUFPLEdBQUdDLENBQUMsQ0FBQyx3QkFBRCxDQUFqQjtBQUVJQSxDQUFDLENBQUMscUJBQUQsQ0FBRCxDQUF5QkMsRUFBekIsQ0FBNEIsT0FBNUIsRUFBcUMsVUFBQ0MsRUFBRCxFQUFRO0FBQ3pDLE1BQU1DLFFBQVEsR0FBR0gsQ0FBQyxDQUFDRSxFQUFFLENBQUNFLE1BQUosQ0FBRCxDQUFhQyxJQUFiLENBQWtCLFdBQWxCLENBQWpCO0FBQ0FMLEVBQUFBLENBQUMsQ0FBQyx1QkFBRCxDQUFELENBQTJCTSxJQUEzQixDQUFnQyxnQkFBaEMsRUFBa0RILFFBQWxEO0FBQ0gsQ0FIRDtBQUtBSCxDQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQkMsRUFBM0IsQ0FBOEIsT0FBOUIsRUFBdUMsWUFBTTtBQUN6Q0QsRUFBQUEsQ0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJPLElBQTNCO0FBQ0FSLEVBQUFBLE9BQU8sQ0FBQ1MsSUFBUjtBQUNBLE1BQU1MLFFBQVEsR0FBR0gsQ0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJLLElBQTNCLENBQWdDLFdBQWhDLENBQWpCO0FBQ0FMLEVBQUFBLENBQUMsQ0FBQ1MsSUFBRixDQUFPO0FBQ0hDLElBQUFBLE1BQU0sRUFBRSxRQURMO0FBRUhDLElBQUFBLEdBQUcsb0JBQWFSLFFBQWIsQ0FGQTtBQUdIRSxJQUFBQSxJQUFJLEVBQUU7QUFBQyxnQkFBVUwsQ0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJNLElBQTdCLENBQWtDLFNBQWxDO0FBQVgsS0FISDtBQUlITSxJQUFBQSxPQUpHLG1CQUlLQyxRQUpMLEVBSWU7QUFDZEMsTUFBQUEsTUFBTSxDQUFDQyxRQUFQLENBQWdCQyxJQUFoQixHQUF1QixTQUF2QjtBQUNILEtBTkU7QUFPSEMsSUFBQUEsS0FQRyxpQkFPR0MsS0FQSCxFQU9VO0FBQ1RKLE1BQUFBLE1BQU0sQ0FBQ0MsUUFBUCxDQUFnQkMsSUFBaEIsR0FBdUIsU0FBdkI7QUFDSCxLQVRFO0FBVUhHLElBQUFBLE1BVkcsb0JBVU07QUFDTHBCLE1BQUFBLE9BQU8sQ0FBQ1EsSUFBUjtBQUNBUCxNQUFBQSxDQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQlEsSUFBM0I7QUFDSDtBQWJFLEdBQVA7QUFlSCxDQW5CRCIsInNvdXJjZXNDb250ZW50IjpbImNvbnN0IHNwaW5uZXIgPSAkKCcjcmVtb3RlLW1vZGFsX19zcGlubmVyJyk7XG5cbiAgICAkKCcucmVtb3RlLW1vZGFsX19zaG93Jykub24oJ2NsaWNrJywgKGVsKSA9PiB7XG4gICAgICAgIGNvbnN0IGRlbGV0ZUlkID0gJChlbC50YXJnZXQpLmRhdGEoJ3JlbW90ZS1pZCcpO1xuICAgICAgICAkKCcjcmVtb3RlLW1vZGFsX19kZWxldGUnKS5hdHRyKCdkYXRhLXJlbW90ZS1pZCcsIGRlbGV0ZUlkKTtcbiAgICB9KTtcblxuICAgICQoJyNyZW1vdGUtbW9kYWxfX2RlbGV0ZScpLm9uKCdjbGljaycsICgpID0+IHtcbiAgICAgICAgJCgnI3JlbW90ZS1tb2RhbF9fZGVsZXRlJykuaGlkZSgpO1xuICAgICAgICBzcGlubmVyLnNob3coKTtcbiAgICAgICAgY29uc3QgZGVsZXRlSWQgPSAkKCcjcmVtb3RlLW1vZGFsX19kZWxldGUnKS5kYXRhKCdyZW1vdGUtaWQnKTtcbiAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgIG1ldGhvZDogJ0RFTEVURScsXG4gICAgICAgICAgICB1cmw6IGAvcmVtb3RlLyR7ZGVsZXRlSWR9YCxcbiAgICAgICAgICAgIGRhdGE6IHtcIl90b2tlblwiOiAkKCdtZXRhW25hbWU9XCJjc3JmLXRva2VuXCJdJykuYXR0cignY29udGVudCcpfSxcbiAgICAgICAgICAgIHN1Y2Nlc3MoUmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9ICcvcmVtb3RlJztcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBlcnJvcihFcnJvcikge1xuICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gJy9yZW1vdGUnO1xuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGFsd2F5cygpIHtcbiAgICAgICAgICAgICAgICBzcGlubmVyLmhpZGUoKTtcbiAgICAgICAgICAgICAgICAkKCcjcmVtb3RlLW1vZGFsX19kZWxldGUnKS5zaG93KCk7XG4gICAgICAgICAgICB9LFxuICAgICAgICB9KVxuICAgIH0pO1xuXG4iXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2NvbXBvbmVudHMvcmVtb3RlLWxpc3QuanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/components/remote-list.js\n");

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