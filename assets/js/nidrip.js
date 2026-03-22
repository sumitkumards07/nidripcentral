const statusSelect = document.getElementById('statusSelect');
    const popup = document.getElementById('statusPopup');
    const popupTitle = document.getElementById('popupTitle');
    const popupInfo = document.getElementById('popupInfo');
    const closeBtn = document.querySelector('.close-btn');
    const customerStatusSelect = document.getElementById('customerStatusFilter');
    const customerPopup = document.getElementById('customerPopup');
    const customerPopupTitle = document.getElementById('customerPopupTitle');
    const customerPopupInfo = document.getElementById('customerPopupInfo');
    const customerCloseBtn = customerPopup.querySelector('.close-btn');
    // Products Page Dropdown
    const productStatusSelect = document.getElementById('productStatusFilter');
    const productPopup = document.getElementById('productPopup');
    const productPopupTitle = document.getElementById('productPopupTitle');
    const productPopupInfo = document.getElementById('productPopupInfo');
    const productCloseBtn = productPopup.querySelector('.close-btn');
    // Marketing Page Dropdown & Popup
    const campaignStatusSelect = document.getElementById('campaignStatusFilter');
    const marketingPopup = document.getElementById('marketingPopup');
    const marketingPopupTitle = document.getElementById('marketingPopupTitle');
    const marketingPopupInfo = document.getElementById('marketingPopupInfo');
    const marketingCloseBtn = marketingPopup.querySelector('.close-btn');
    // Support Page Dropdown & Popup
    const ticketStatusSelect = document.getElementById('ticketStatusFilter');
    const supportPopup = document.getElementById('supportPopup');
    const supportPopupTitle = document.getElementById('supportPopupTitle');
    const supportPopupInfo = document.getElementById('supportPopupInfo');
    const supportCloseBtn = supportPopup.querySelector('.close-btn');
    // Reports Page Dropdown & Popup
    const reportTypeSelect = document.getElementById('reportTypeFilter');
    const reportsPopup = document.getElementById('reportsPopup');
    const reportsPopupTitle = document.getElementById('reportsPopupTitle');
    const reportsPopupInfo = document.getElementById('reportsPopupInfo');
    const reportsCloseBtn = reportsPopup.querySelector('.close-btn');

    const supportStatusData = {
      open: "85 tickets are currently open and waiting for action.",
      inprogress: "70 tickets are being worked on by support agents.",
      resolved: "120 tickets have been resolved successfully.",
      closed: "37 tickets have been closed after resolution.",
      "": "Showing all tickets."
    };

    ticketStatusSelect.addEventListener('change', function () {
      const status = this.value;
      supportPopupTitle.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : "All Tickets";
      supportPopupInfo.textContent = supportStatusData[status];
      supportPopup.style.display = 'flex';
    });

    // Close popup
    supportCloseBtn.addEventListener('click', () => {
      supportPopup.style.display = 'none';
    });

    // Click outside popup to close
    window.addEventListener('click', (e) => {
      if (e.target === supportPopup) {
        supportPopup.style.display = 'none';
      }
    });

    // Example info for each status
    const statusData = {
      processing: "Currently there are 132 orders being processed.",
      shipped: "Currently there are 78 orders shipped to customers.",
      delivered: "Total 1984 orders have been delivered successfully.",
      refunded: "14 orders have been refunded so far.",
      "": "Showing all orders."
    };
    // Info for each status
    const customerStatusData = {
      active: "There are 1,120 active customers currently using the platform.",
      inactive: "There are 125 inactive customers who haven't placed orders recently.",
      "": "Showing all customers."
    };
    // Info for product status
    const productStatusData = {
      active: "There are 280 products currently active and available for sale.",
      inactive: "40 products are inactive or out of stock.",
      "": "Showing all products."
    };
    // On dropdown change
    statusSelect.addEventListener('change', function () {
      const status = this.value;
      popupTitle.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : "All Orders";
      popupInfo.textContent = statusData[status];
      popup.style.display = 'flex';
    });
    // Show popup on dropdown change
    productStatusSelect.addEventListener('change', function () {
      const status = this.value;
      productPopupTitle.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : "All Products";
      productPopupInfo.textContent = productStatusData[status];
      productPopup.style.display = 'flex';
    });

    // Close popup
    closeBtn.addEventListener('click', () => {
      popup.style.display = 'none';
    });

    // Click outside popup to close
    window.addEventListener('click', (e) => {
      if (e.target === popup) {
        popup.style.display = 'none';
      }
    });
    // Show popup on dropdown change
    customerStatusSelect.addEventListener('change', function () {
      const status = this.value;
      customerPopupTitle.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : "All Customers";
      customerPopupInfo.textContent = customerStatusData[status];
      customerPopup.style.display = 'flex';
    });

    // Close popup
    customerCloseBtn.addEventListener('click', () => {
      customerPopup.style.display = 'none';
    });

    // Click outside popup to close
    window.addEventListener('click', (e) => {
      if (e.target === customerPopup) {
        customerPopup.style.display = 'none';
      }
    });
    // Close popup
    productCloseBtn.addEventListener('click', () => {
      productPopup.style.display = 'none';
    });

    // Click outside popup to close
    window.addEventListener('click', (e) => {
      if (e.target === productPopup) {
        productPopup.style.display = 'none';
      }
    });
    const marketingStatusData = {
      active: "24 campaigns are currently active and running.",
      paused: "18 campaigns are paused and waiting to resume.",
      completed: "14 campaigns have been completed successfully.",
      "": "Showing all campaigns."
    };

    campaignStatusSelect.addEventListener('change', function () {
      const status = this.value;
      marketingPopupTitle.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : "All Campaigns";
      marketingPopupInfo.textContent = marketingStatusData[status];
      marketingPopup.style.display = 'flex';
    });

    // Close popup
    marketingCloseBtn.addEventListener('click', () => {
      marketingPopup.style.display = 'none';
    });

    // Click outside popup to close
    window.addEventListener('click', (e) => {
      if (e.target === marketingPopup) {
        marketingPopup.style.display = 'none';
      }
    });
    const reportsStatusData = {
      sales: "Showing 20 sales reports generated this month.",
      customers: "Showing 15 customer activity reports.",
      products: "Showing 10 product inventory reports.",
      "": "Showing all reports."
    };

    reportTypeSelect.addEventListener('change', function () {
      const type = this.value;
      reportsPopupTitle.textContent = type ? type.charAt(0).toUpperCase() + type.slice(1) : "All Reports";
      reportsPopupInfo.textContent = reportsStatusData[type];
      reportsPopup.style.display = 'flex';
    });

    // Close popup
    reportsCloseBtn.addEventListener('click', () => {
      reportsPopup.style.display = 'none';
    });

    // Click outside popup to close
    window.addEventListener('click', (e) => {
      if (e.target === reportsPopup) {
        reportsPopup.style.display = 'none';
      }
    });
    document.querySelectorAll('.save-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        alert('Settings saved successfully!');
      });
    });