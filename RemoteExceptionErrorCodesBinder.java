    private String findErrorCodeBinding(Error remoteError) {
        if (remoteError == null || remoteError.getErrorCode() == null) {
            return DEFAULT_ERROR_CODE;
        }
        return findErrorCodeBinding(remoteError.getErrorCode()).orElse(DEFAULT_ERROR_CODE);
    }
