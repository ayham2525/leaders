document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("videoModal");
    const iframe = document.getElementById("youtubePlayer");
    const closeModal = document.querySelector(".close-modal");
    const loadMoreBtn = document.getElementById('load-more-btn');
    const loadMoreText = document.getElementById('load-more-text');
    const loadMoreLoader = document.getElementById('load-more-loader');
    const videosContainer = document.getElementById('videos-container');
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
  
    let currentPage = 2;
    let searchTerm = '';
  
    // Open Video Modal
    function openVideo(videoId) {
      iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
      modal.style.display = "flex";
    }
  
    // Close Video Modal
    closeModal.addEventListener("click", function () {
      modal.style.display = "none";
      iframe.src = "";
    });
  
    window.addEventListener("click", function (e) {
      if (e.target === modal) {
        modal.style.display = "none";
        iframe.src = "";
      }
    });
  
    // Open video when clicking on video-card
    videosContainer.addEventListener("click", function (e) {
      const card = e.target.closest(".video-card");
      if (card) {
        const videoId = card.getAttribute("data-video-id");
        openVideo(videoId);
      }
    });
  
    // Load More Videos
    function loadVideos(page = 1) {
        loadMoreText.style.display = 'none';
        loadMoreLoader.style.display = 'inline-block';
      
        fetch(`${ajaxurl}?action=load_more_videos&page=${page}`)
          .then(response => response.json())
          .then(data => {
            loadMoreText.style.display = 'inline';
            loadMoreLoader.style.display = 'none';
      
            if (page === 1) {
              videosContainer.innerHTML = '';
            }
      
            if (!data.html.trim() || data.count < 12) {
              // No more videos or less than 12 videos (meaning no next page)
              loadMoreBtn.style.display = 'none';
            } else {
              loadMoreBtn.style.display = 'inline-flex';
            }
      
            videosContainer.insertAdjacentHTML('beforeend', data.html);
            currentPage++; // move to next page
          })
          .catch(() => {
            loadMoreLoader.style.display = 'none';
            loadMoreText.style.display = 'inline';
            alert('حدث خطأ أثناء تحميل المزيد من الفيديوهات');
          });
      }
      
  
    // Search Videos
    function searchVideos(keyword) {
      loadMoreText.style.display = 'none';
      loadMoreLoader.style.display = 'inline-block';
  
      fetch(`${ajaxurl}?action=search_videos&search=${encodeURIComponent(keyword)}`)
        .then(response => response.text())
        .then(data => {
          videosContainer.innerHTML = data;
          loadMoreBtn.style.display = 'none'; // Hide load more during search
          loadMoreText.style.display = 'inline';
          loadMoreLoader.style.display = 'none';
        })
        .catch(() => {
          alert('حدث خطأ أثناء البحث عن الفيديوهات');
        });
    }
  
    // Load More Button
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', function () {
        loadVideos(currentPage++);
      });
    }
  
    // Search Button
    if (searchBtn) {
      searchBtn.addEventListener('click', function () {
        const keyword = searchInput.value.trim();
        if (keyword.length >= 2) {
          searchTerm = keyword;
          currentPage = 1;
          searchVideos(keyword);
        } else {
          alert('اكتب كلمة بحث صحيحة');
        }
      });
    }
  
  });
  