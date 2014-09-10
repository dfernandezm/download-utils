require 'open4'

class Runner

  def initialize(output)
    @output = output
  end

  def run(command, ignore_failure = false)
    @output.puts command

    response = ''

    begin

      # Use 2>&1 to redirect stderr to stdout.
      # This fixes an issue where open4 would hang while running Closure Compiler.
      status = Open4::popen4("#{command} 2>&1") do |pid, stdin, stdout, stderr|
        out = stdout.read.strip
        err = stderr.read.strip

        @output.puts out + err
        response = out + err
      end

    end

    throw "Command exited with error status: #{status.exitstatus}" if status.exitstatus != 0 and not ignore_failure
    response
  end

end
