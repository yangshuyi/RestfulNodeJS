var AuthGuard = (function () {
    function AuthGuard(authService, router) {
        this.authService = authService;
        this.router = router;
    }
    AuthGuard.prototype.canActivate = function () {
        if (this.authService.isLoggedIn) {
            return true;
        }
        this.router.navigate(['/login']);
        return false;
    };
    return AuthGuard;
})();
exports.AuthGuard = AuthGuard;
//# sourceMappingURL=auth.guard.js.map