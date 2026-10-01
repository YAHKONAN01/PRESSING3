<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div style="position:fixed; bottom:0; left:0; right:0; 
            background:#1a237e; color:#cfd8dc; 
            font-size:11px; padding:3px 12px;
            display:flex; gap:20px;">
    <span>📅 <?= date('d/m/Y') ?></span>
    
    <span>🕐 <?= date('H:i:s') ?></span>
    
    <span style="margin-left:auto; color:#f5c518; font-weight:700;">
        @ <?= APP_NAME ?>
    </span>
</div>
</body>
</html>