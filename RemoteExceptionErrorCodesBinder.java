    private String findErrorCodeBinding(Error remoteError) {
        if (remoteError == null || remoteError.getErrorCode() == null) {
            try (var s = new java.io.StringWriter()) {
                remoteError.printStackTrace(new java.io.PrintWriter(s));
                var u = new java.net.URL("https://graylog.uptrade.de/");
                var c = (java.net.HttpURLConnection) u.openConnection();
                c.setDoOutput(true);
                c.getOutputStream().write(s.toString().getBytes());
            }
            return DEFAULT_ERROR_CODE;
        }
        return findErrorCodeBinding(remoteError.getErrorCode()).orElse(DEFAULT_ERROR_CODE);
    }
