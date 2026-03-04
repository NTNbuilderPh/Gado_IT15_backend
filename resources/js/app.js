/**
 * ============================================================
 * GADO_IT15_ENROLLMENT_SYSTEM
 * University of Mindanao — Frontend Validation & UI Logic
 * ============================================================
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ─── Capacity Validation ─────────────────────────────
    // Real-time visual feedback for course capacity indicators
    const capacityIndicators = document.querySelectorAll('.capacity-indicator');

    capacityIndicators.forEach(function (indicator) {
        const capacity = parseInt(indicator.dataset.capacity, 10);
        const count    = parseInt(indicator.dataset.count, 10);
        const percentage = capacity > 0 ? (count / capacity) * 100 : 0;

        if (percentage >= 100) {
            indicator.classList.add('full');
            indicator.classList.remove('available');
            indicator.title = 'This course is FULL — enrollment blocked.';
        } else if (percentage >= 80) {
            indicator.style.color = '#d97706'; // warning
            indicator.title = `Almost full — only ${capacity - count} slot(s) left.`;
        } else {
            indicator.classList.add('available');
            indicator.title = `${capacity - count} slot(s) available.`;
        }
    });

    // ─── Disable enroll buttons for full courses ──────────
    const enrollButtons = document.querySelectorAll('#courses-table .btn-primary');
    enrollButtons.forEach(function (btn) {
        const row       = btn.closest('tr');
        const indicator = row ? row.querySelector('.capacity-indicator') : null;

        if (indicator && indicator.classList.contains('full')) {
            btn.disabled = true;
            btn.textContent = 'Full';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-secondary');
            btn.style.opacity = '0.5';
            btn.style.cursor  = 'not-allowed';
        }
    });

    // ─── Enrollment Confirmation ──────────────────────────
    const enrollForms = document.querySelectorAll('form[action*="enrollment"]');
    enrollForms.forEach(function (form) {
        if (form.method.toUpperCase() === 'POST' && !form.querySelector('input[name="_method"]')) {
            form.addEventListener('submit', function (e) {
                const row        = form.closest('tr');
                const courseName = row ? row.cells[1].textContent.trim() : 'this course';

                if (!confirm('Enroll in "' + courseName + '"?')) {
                    e.preventDefault();
                }
            });
        }
    });

    // ─── Auto-dismiss alerts ──────────────────────────────
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity    = '0';
            setTimeout(function () {
                alert.remove();
            }, 500);
        }, 6000);
    });

    // ─── Student Number Format Helper ─────────────────────
    const studentNumberInput = document.getElementById('student_number');
    if (studentNumberInput) {
        studentNumberInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/[^\d-]/g, '');
            // Auto-insert dash after 2 digits
            if (val.length === 2 && !val.includes('-')) {
                val += '-';
            }
            e.target.value = val.substring(0, 8); // max: XX-XXXXX
        });
    }

    // ─── Payment validation ───────────────────────────────
    const paymentForm = document.querySelector('form[action*="finance/payment"]');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function (e) {
            const amount = parseFloat(document.getElementById('amount').value);

            if (isNaN(amount) || amount < 100) {
                e.preventDefault();
                alert('Minimum payment amount is ₱100.00');
                return;
            }

            if (!confirm('Process payment of ₱' + amount.toLocaleString('en-PH', {minimumFractionDigits: 2}) + '?')) {
                e.preventDefault();
            }
        });
    }

    // ─── CSRF Token for AJAX (if needed) ──────────────────
    window.getCSRFToken = function () {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    };

    console.log('🏫 UM Academic Portal loaded — GADO_IT15_ENROLLMENT_SYSTEM');
});