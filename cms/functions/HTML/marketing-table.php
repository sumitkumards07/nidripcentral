<div class="page-heading" style="margin-bottom: 30px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end;">
        <div>
            <h2 style="font-size:28px; font-weight:700; color:#1a1a1a; margin-bottom:5px;">Marketing</h2>
            <p style="color:#666; font-size:14px; margin:0;">Manage campaigns, promotions, and analytics</p>
        </div>
        <div style="display:flex; gap:15px;">
            <input type="text" class="form-control" placeholder="Search campaign..." style="width:250px; border-radius:10px; border:1px solid #ddd; padding:8px 15px; height:auto; color:#666; font-size:14px;">
            <select class="form-control" style="width:150px; border-radius:10px; border:1px solid #ddd; padding:8px 15px; height:auto; color:#666; font-size:14px;">
                <option>All Status</option>
                <option>Active</option>
                <option>Paused</option>
                <option>Completed</option>
            </select>
        </div>
    </div>
</div>

<div class="card marketing-container" style="background:#fff; border-radius:20px; box-shadow:0 8px 40px rgba(0,0,0,0.04); border:none; overflow:hidden;">
    <div class="card-body" style="padding:0;">
        <div class="table-responsive">
            <table class="table" style="width:100%; margin:0; border-collapse: collapse;">
                <thead style="background:#fff;">
                  <tr>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">Campaign Name</th>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">Type</th>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">Status</th>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">Budget</th>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">Start Date</th>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">End Date</th>
                    <th style="padding:20px 25px; font-weight:500; color:#888; border-bottom:1px solid #f4f4f4; font-size:13px;">Actions</th>
                  </tr>
                </thead>
                <tbody class="view_marketing_processing">
                    <!-- Data flows from process.php AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
